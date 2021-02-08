<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project
This was a learning project to see the full process of start to finish of a Laravel application. It's currently hosted as a Heroku app.

### Learned
Summary of the things learned in this project are as follows.

#### Migrations
Migrations files are super useful when working on a team and for deploying database changes to production environments as well. An example is the Notes table which is pretty simple we only need a few things:
* Id
* title
* content
* soft-delete field
* user_id (owner)

```
public function up()
{
    Schema::create('notes', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->string('title'); // Smaller title field.
        $table->text('content'); // Bigger content field.
        $table->boolean('deleted')->default('0'); // Adding default value so we don't need to specify all new notes are not deleted...
        $table->integer('user_id'); // Fits the model of 'user' _ 'id' so Eloquent will automatically know what this field is used for.
    });
}
```

There are 2 function in a migration file. up() and down() and they're just opposites of each other. up() is for creating the table, so it should describe what the table should look like when created. down() is for tearing it down and is usually just 'Schema::dropIfExists('table_name');'

After pulling a project with migration files you can run
```
php artisan migrate
```

and the tables should be automatically created for you and you're all set to run the project.

If you mess up your tables and  you want to refresh your migrations (roll back all changes and start fresh again with new data and everything)
```
php artisan migration:refresh
```

This is where seeding data comes in, so you can have some basic data ready to seed into a freshly refreshed database.

#### Eloquent (ORM)
This simple relationship is easy to accomplish in the Http\Models\Note.php file we tell Eloquent about the relationship by adding
```
public function user()
{
    return $this->belongsTo('App\Models\User');
}
```
So now it will automatically associate a Note with a user by converting the object name and converting to snake case and adding id to the end. So the Foreign Key it will automatically use is 'user_id'.

Now we want to create the inverse of this relationship, because a Note has a owning User but a User also has many Notes so we open Http\Models\User.php
```
public function notes()
{
    return $this->hasMany('App\Models\Note');
}
```

Now with this in code we can use this relationship to say get all Notes that a User owns by doing something like this.
```
$user = Auth::user(); // Get logged in User first.
$notes = $user->notes(); // Get notes this User owns.
$singleNote = $user->notes()->find(1); // Alternatively we can further filter (Thanks to Eloquent) and get Notes a user owns, but only a single id (1 in this case). 
```

#### Authentication
Using the built in authentication is just too easy with Laravel, I went with the LiveWire method because it seemed closest to what I wanted then stripped out everything that didn't fit with the project (wanted it simple, no password recory because that wasn't the point of the project).

Next I'll need to look into how these are implemented though, because for now it's just kind of magic to me, which isn't good.

#### Testing
TBD, need to do more work here.


## Live Project
https://laravel-notes-app.herokuapp.com/
