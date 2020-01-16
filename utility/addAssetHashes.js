const crypto = require('crypto');
const fs = require('fs');
const path = require('path');

const sourceDir = 'public/assets';

const buildHashData = async (assetPath) => {
    const contents = await fs.promises.readFile(assetPath, 'binary');
    const hash = crypto.createHash('md5').update(contents).digest('hex');
    
    return {
        assetPath,
        hashedAssetPath: assetPath.replace(/(^.*)(\..*)$/i, `$1_${hash}$2`)
    };
}

fs.readdir(sourceDir, async (err, files) => {
    const filesToBeHashed = files.filter((filePath) => new RegExp(/^.*\.bundle\.(js|css)$/i).test(filePath));

    const hashData = await Promise.all(
        filesToBeHashed.map(
            (filePath) => buildHashData(path.join(sourceDir, filePath))
        )
    );
        
    hashData.forEach((paths) => {
        fs.rename(paths.assetPath, paths.hashedAssetPath, function(err) {
            if (err) return console.log(`ERROR when adding hashes to asset filenames: ${err}`);
            console.log(`Renamed asset file ${paths.assetPath} to ${paths.hashedAssetPath}`);
        });
    });
});
