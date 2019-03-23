# TheAdmin Starter

This directory includes what you need to quickly start your project. Just make a copy of this directory and start developing! You can read this guide online at http://thetheme.io/theadmin/help/article-quick-start.html

In this file, you'll find how to use embeded Grunt tasks for a better development. If you dont't need a server or you are not going to user SASS language, just ignore the rest of content.

## Installation

Install `Node` and `grunt-cli` if they are not installed before:

1. [Download and install Node](https://nodejs.org/download)
2. Install the Grunt command line tools, with `npm install -g grunt-cli`.

Then, open your command line in this directory and run following commands:

1. Install project dependencies with `npm install`.
2. Run Grunt with `grunt`.

After few seconds, you'll see a new tab opened in your default browser with a URL like this: <http://localhost:3000> (protocol might be different number).

The running task can help you in following ways:

- Write your SASS inside `src/assets/css/style.scss`. The running grunt task will compile and minify your code into `style.min.css` upon each modification.
- Write your CSS inside `src/assets/css/style.css`. The running grunt task will minify your code into `style.min.css` upon each modification.
- Write your Javascript inside `src/assets/js/script.js`. The running grunt task will minify your code into `script.min.js` upon each modification.
- Create and modify any HTML file in any directory as you wish. The running grunt task is observing them and will reload the browser by each modification to HTML files, as well as to .css and .js files.

## Deployment

Once you finish development, run `grunt build` command to place your production code inside a `dist` directory. This command make a copy of all files except unnecessary ones, such as .scss files and unminified .css and .js files. Now you can use the dist folder in your server side coding.
