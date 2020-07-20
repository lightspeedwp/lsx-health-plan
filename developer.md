# Contents

# Setup

## Step 1
Skip this step if you have node installed globally already.

Open your terminal and run `npm install -g`


## Important

You may need to still install a package globally if it is missing from your folder.
```
npm install -g <package>
```

## Step 2
```
npm link gulp
npm link gulp-autoprefixer
npm link gulp-concat
npm link gulp-gettext
npm link gulp-jshint
npm link gulp-plumber
npm link gulp-rename
npm link gulp-rtlcss
npm link gulp-sass
npm link gulp-sort
npm link gulp-sourcemaps
npm link gulp-uglify
npm link gulp-util
npm link gulp-wp-pot
```

### Tips

If you are having problems try set the permissions for the global node modules folder.

```
sudo chown -R root:YOUR_USERNAME /usr/local/lib/node_modules/
sudo chmod -R 775 /usr/local/lib/node_modules/
```
