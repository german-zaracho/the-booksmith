<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert([
            [
                'news_id' => '1',
                'title' => 'The Hobbit first edition fetches more than £31k',
                'description' => 'A rare first edition of JRR Tolkien`s 1937 novel The Hobbit has sold for £31,200 at auction. The first impression copy is one of only 1,500 original pressings of the fantasy novel that went on to spawn Tolkien`s universe of Middle-Earth. It was found in a chest of drawers at a home in Berkshire, where it had been left after being inherited. The novel was sold by Kinghams Auctioneers in Moreton in Marsh, Gloucestershire, on Friday.',
                'img' => 'news1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'news_id' => '2',
                'title' => 'Sleep Tight: Twisted, Dark, and Suspenseful Horror Novel',
                'description' => 'I’ll be honest at first glance the big draw to Sleep Tight by J.H. Markert was the fantastic cover art and title design, but after the first few pages of this horror novel we were in for the long haul. Father Silence once terrorized the rural town of Twisted Tree, disguising himself as a priest to prey on the most vulnerable members of society. When the police finally found his “House of Horrors,” they uncovered nineteen bodies and one survivor–a boy now locked away in a hospital for the criminally insane.',
                'img' => 'news2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'news_id' => '3',
                'title' => '‘The Coworker’ by Freida McFadden is stuffed with twists and turns',
                'description' => 'Part one of this book highlights the relationship in an office between a sales rep and her accountant coworker. Natalie is beautiful, popular and a leader in the sale of nutritional supplements for five years running. Dawn is shy, retiring and probably on the autism spectrum. There is constant undermining of Dawn by Natalie through the spreading of rumors, teasing and other subtle digs.',
                'img' => 'news3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'news_id' => '4',
                'title' => 'When a Smart House Turns Evil',
                'description' => 'In Mason Coile’s new horror novel, “William,” an intelligent robot begins to lead its feckless creator to terrible places in the name of “freedom.”. The uncanny aspect of A.I. is front and center in “William,” Mason Coile’s slim, gripping novel about the horror of watching software embrace its will to power. The title character is a robot built to house an experimental A.I. The intelligent William quotes Goethe’s Mephistopheles and speaks with an eloquence at odds with its grotesque, rudimentary appearance: “Bulging eyes, round as marbles. Ears the size of ashtrays, the color of curdled milk.”',
                'img' => 'news4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
