<h1>URL Shortner Service - Project Details</h1>

<h3>Requirements</h3>
<ol>
    <li>Composer v2.5</li>
    <li>PHP ^v8.3</li>
    <li>MySQL v8.0.44</li>
</ol>

<h3>Stack</h3>
<ol>
    <li>Framework - Laravel v12</li>
    <li>Database - MySQL v8.0</li>
    <li>Blade templating engine</li>
</ol>

<h3>Instructions for project setup</h3>
<ol>
    <li>Clone the repo - <code>git clone [repo_url]</code></li>
    <li>Install project dependencies - <code>composer install</code></li>
    <li>Setup database for you project.</li>
    <li>Create a .env file at the root of the project - <code>cp .env.example .env</code></li>
    <li>
        Configure your database credentials in the env file - 
        <code>
            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=[your_database_name]
            DB_USERNAME=[your_username]  
            DB_PASSWORD=[your_password]
        </code>
    </li>
    <li>Put this in env file - <code>ROOT_DOMAIN="http://127.0.0.1:8000"</code></li>
    <li>Generate key for your application - <code>php artisan key:generate</code></li>
    <li>Run all the migrations - <code>php artisan migrate</code></li>
    <li>
        Run the seeders in the following order -
        <ul>
            <li>php artisan db:seed --class=RoleSeeder</li>
            <li>php artisan db:seed --class=SuperadminSeeder</li>
        </ul> 
    </li>
    <li>Run the development server - <code>php artisan serve</code></li>
    <li>Access the URL in the browser</li>
</ol>