<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post 
{
    private static $blog_post = [
        [
        'title'=> 'Judul Iya Nih gimnana dong',
        'slug'=> 'judul-satu',        
        'author'=> 'Driyo Agung',
        'body'=> 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sed tempora eius iusto? Adipisci natus ad earum porro voluptatibus impedit aspernatur dolorem rerum. Impedit, quia dicta!',
        ],
        [
        'title'=> 'Judul Dua Sayang',
        'slug'=> 'judul-dua',
        'author'=> 'Ovie Harindrika',
        'body'=> 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate officia harum iusto rerum saepe facilis autem, accusamus dolores reprehenderit modi molestiae eaque quod porro, aut labore. Qui, autem ea, fugit distinctio recusandae nulla laboriosam aut consequuntur quo quas, repellendus amet! Recusandae commodi minima unde aliquam amet doloremque nulla saepe cupiditate.',
            ]
        ];

        public static function all(){
            return collect(self::$blog_post);
        }
        public static function find($slug){
            $posts = static::all();
        
    return $posts->firstWhere('slug',$slug);
    }
}
