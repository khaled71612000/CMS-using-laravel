<?php

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author1 = App\User::create([
            'name' => 'John doe',
            'Email' => 'johan@gmail.com',
            'password' => Hash::make('password')
        ]);
        $author2 = App\User::create([
            'name' => 'b doe',
            'Email' => 'sads@gmail.com',
            'password' => Hash::make('password')
        ]);
        $author3 = App\User::create([
            'name' => 'a doe',
            'Email' => 'johasdafan@gmail.com',
            'password' => Hash::make('password')
        ]);
        $author4 = App\User::create([
            'name' => 'c doe',
            'Email' => 'johasfdsfn@gmail.com',
            'password' => Hash::make('password')
        ]);

        $category1 = Category::create([
            'name' =>'News'
        ]);
        $category2 = Category::create([
            'name' =>'Marketing'
        ]);
        $category3 = Category::create([
            'name' =>'Partnership'
        ]);
        $post1 = Post::create([
            'title' => 'We love php',
            'description' => 'We love phpphpphpphpphpphpphpphpphpphpphpphpphpphpphp',
            'content' => ' phpphpphpphpphpphpphp ',
            'category_id' => $category1->id,
            'image' => 'posts/1.jpg',
            'user_id' => $author1->id
        ]);
        $post2 = Post::create([
            'title' => 'Laravel is awesome',
            'description' => 'awesome awesome awesomeawesomeawesomeawesomeawesomeawesomeawesomeawesome',
            'content' => ' awesomeawesomeawesomeawesomeawesomeawesome ',
            'category_id' => $category2->id,
            'image' => 'posts/2.jpg',
            'user_id' => $author2->id


        ]);
        $post3 = Post::create([
            'title' => 'html is html',
            'description' => 'html html htmlhtmlhtmlhtmlhthtmlhtmlhtmlhtmlhtmlml',
            'content' => ' htmlhtmlhtmlhtmlhtml ',
            'category_id' => $category3->id,
            'image' => 'posts/3.jpg',
            'user_id' => $author3->id


        ]);
        $post4 = Post::create([
            'title' => 'csscsscssc',
            'description' => 'html html csscsscsscsscsscsscsscsscsscsscsscsscsscss',
            'content' => ' css ',
            'category_id' => $category2->id,
            'image' => 'posts/4.jpg',
            'user_id' => $author4->id


        ]);
        $tag1 = Tag::create([
            'name' =>'job'
        ]);
        $tag2 = Tag::create([
            'name' =>'Customer'
        ]);
        $tag3 = Tag::create([
            'name' =>'record'
        ]);

        $post1->tags()->attach([$tag1->id,$tag2->id]);
        $post2->tags()->attach([$tag2->id,$tag3->id]);
        $post3->tags()->attach([$tag1->id,$tag3->id]);
    }

}
