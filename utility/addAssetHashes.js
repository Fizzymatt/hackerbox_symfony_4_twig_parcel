const crypto = require('crypto');
const fs = require('fs');
const path = { resolve, dirname, basename } = require('path');
const { readdir, stat } = require('fs').promises;
const directories = { public: 'public', assets: 'assets' };

const buildHashData = async (assetPath) => {
    // read the contents of a specified file
    const contents = await fs.promises.readFile(assetPath, 'binary');
    // create an MD5 hash of the contents of the file
    const hash = crypto.createHash('md5').update(contents).digest('hex');

    // return an object containing both the original asset path, and also the asset path with an MD5 hash inserted into the filename
    return {
        assetPath,
        hashedAssetPath: assetPath.replace(/(^.*)(\.(js|css))$/i, `$1_${hash}$2`)
    };
}

async function* getFilesToHash(rootPath) {
    // get the names of all the files and directories that are inside a specified directory
    const fileNames = await readdir(rootPath);
    for (const fileName of fileNames) {
        // build a complete path to the file
        const fullPath = resolve(rootPath, fileName);
        // if the file is actually a directory, then we call this function recursively and yield the results so that we can
        // access the files inside
        if ((await stat(fullPath)).isDirectory()) yield* getFilesToHash(fullPath);
        // if the file is in the root of the assets directory, and it's not the "main.xxxxxxxx.js" file (which is created by Parcel
        // if its code-splitting functionality is in use) then simply yield the full path of that file
        if (!(basename(dirname(fullPath)) === directories.assets && new RegExp(/main\..+$/).test(fileName))) yield fullPath;
    }
}

// this self executing anonymous function begins the process
(async () => {
    // for each result returned asynchronously from the getFilesToHash function.......
    for await (const assetPath of getFilesToHash(path.join(directories.public, directories.assets))) {
        // if the asset doesn't have a .css or ,js extension then ignore it
        if (!assetPath.match(/^.*.(js|css)$/i)) continue;

        // get the asset's current path / filename, and also that same path / filename with an MD5 hash included in the filename
        const hashData = await buildHashData(assetPath);

        // rename the existing asset so that its filename now includes the MD5 hash
        fs.rename(hashData.assetPath, hashData.hashedAssetPath, function(err) {
            if (err) return console.log(`ERROR when adding hashes to asset filenames: ${err}`);
            console.log(`Renamed asset file ${hashData.assetPath} to ${hashData.hashedAssetPath}`);
        });
    }
})();
