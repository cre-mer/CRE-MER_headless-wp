# Headless WP w/ Laravel

Headless WP with Laravel is an app built with the intention to have a WP backend to manage posts, and everything else can be built with Laravel framework.

## Installation

Intall with git

```bash
git clone git@github.com:cre-mer/CRE-MER_headless-wp.git
```

## App Structure
CRE-MER_headless-wp/

├── api.my-website/ (your wp directory)

L── my-website/ (your laravel directory)


## Usage
### Setup WP as usual
1. Do the 5 minutes setup as usual.
2. In your wp-config.php edit this line
```php
define('WP_LARAVEL_URL', 'http://my-website.test');
```
3. Activate the blank theme
4. When you're done, log in to the backend and go to Settings -> Permalinks. Select the radio button "Post name" and save your changes.

### Setup Laravel
```bash
cd CRE-MER_headless-wp/my-website
cp .env.example .env
```

A new constant is used in .env
If your website has the url my-website.test and your WP Api has the url api.my-website.test, then go on and edit the `APP_SHORT_URL` to save some time.
```.
APP_SHORT_URL=my-website.test
APP_URL=https://${APP_SHORT_URL}

WP_API_BASE_URL=api.${APP_SHORT_URL}
```
Run `php artisan key:generate`

## Make your first test
1. Go to [http://my-website.test/hallo-world](http://my-website.test/hallo-world). You should see your first WP post.

1. Try to open [http://api.my-website.test](http://api.my-website.test).
1. Try adding a link to other posts and watch how Laravel will reformat the links so your api url will always be hidden.
1. Try to add an image and watch how the image url will be reformatted too!
1. While you're on the post's page, try to add a comment and watch how it will be added in WP!

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)

## Have fun!
