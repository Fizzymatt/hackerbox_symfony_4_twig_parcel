const crypto = require('crypto');
const fs = require('fs');
const path = { resolve, dirname, basename } = require('path');
const { readdir, stat } = require('fs').promises;
const directories = { public: 'public', assets: 'assets' };


const buildHashData = async (assetPath) => {
    const contents = await fs.promises.readFile(assetPath, 'binary');
    const hash = crypto.createHash('md5').update(contents).digest('hex');
    
    return {
        assetPath,
        hashedAssetPath: assetPath.replace(/(^.*)(\.(js|css))$/i, `$1_${hash}$2`)
    };
}

const filesToBeHashed = (files) => files.filter((filePath) => new RegExp(/^.*.(js|css)$/i).test(filePath));


async function* getFilesToHash(rootPath) {
    const fileNames = await readdir(rootPath);
    for (const fileName of fileNames) {
        const fullPath = resolve(rootPath, fileName);
        if ((await stat(fullPath)).isDirectory()) yield* getFilesToHash(fullPath);
        if (basename(dirname(fullPath)) !== directories.assets) yield fullPath;
    }
}


(async () => {
    for await (const assetPath of getFilesToHash(path.join(directories.public, directories.assets))) {
        if (!assetPath.match(/^.*.(js|css)$/i)) continue;

        const hashData = await buildHashData(assetPath);
        fs.rename(hashData.assetPath, hashData.hashedAssetPath, function(err) {
            if (err) return console.log(`ERROR when adding hashes to asset filenames: ${err}`);
            console.log(`Renamed asset file ${hashData.assetPath} to ${hashData.hashedAssetPath}`);
        });
    }
})();
