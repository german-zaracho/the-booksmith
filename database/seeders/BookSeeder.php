<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'book_id' => 1,
                'title' => 'Sleep Tight',
                'synopsis' => 'Father Silence once terrorized the rural town of Twisted Tree, disguising himself as a priest to prey on the most vulnerable members of society. When the police finally found his "House of Horrors," they uncovered nineteen bodies and one survivor–a boy now locked away in a hospital for the criminally insane. Nearly two decades later, Father Silence is finally put to death, but by the next morning, the detective who made the original arrest is found dead. A new serial killer is taking credit for the murder and calling himself the Outcast. The detective’s daughter, Tess Claibourne, is a detective herself, haunted by childhood trauma and horrified by the death of her father and the resurgence of Father Silence’s legacy. When Tess’s daughter is kidnapped by the Outcast, Tess is forced to face her worst fears and long-buried memories. With no leads to follow, she travels back to Twisted Tree to visit the boy who survived and see what secrets might be buried in the tangled web of his broken mind.',
                'editorial' => 'Crooked Lane Books',
                'price' => 14.99,
                'image' => 'sleepTight.jpg',
                'author' => 'J. H. Markert',
                'genre_fk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 2,
                'title' => 'The Hobbit',
                'synopsis' => 'When Thorin Oakenshield and his band of dwarves embark upon a dangerous quest to reclaim the hoard of gold stolen from them by the evil dragon Smaug, Gandalf the wizard suggests an unlikely accomplice: Bilbo Baggins, an unassuming Hobbit dwelling in peaceful Hobbiton. Along the way, the company faces trolls, goblins, giant spiders, and worse. But as they journey from the wonders of Rivendell to the terrors of Mirkwood and beyond, Bilbo will find that there is more to him than anyone—himself included—ever dreamed. Unexpected qualities of courage and cunning, and a love of adventure, propel Bilbo toward his great destiny, a destiny that waits in the dark caverns beneath the Misty Mountains, where a twisted creature known as Gollum jealously guards a precious magic ring.',
                'editorial' => 'William Morrow Paperbacks',
                'price' => 12.99,
                'image' => 'theHobbit.jpg',
                'author' => 'J.R.R. Tolkien',
                'genre_fk' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 3,
                'title' => '1984',
                'synopsis' => 'In 1984, London is a grim city in the totalitarian state of Oceania where Big Brother is always watching you and the Thought Police can practically read your mind. Winston Smith is a man in grave danger for the simple reason that his memory still functions. Drawn into a forbidden love affair, Winston finds the courage to join a secret revolutionary organization called the Brotherhood, dedicated to the destruction of the Party. Together with his beloved Julia, he hazards his life in a deadly match against the powers that be.',
                'editorial' => 'Mariner Books',
                'price' => 17.49,
                'image' => '1984.jpg',
                'author' => 'George Orwell',
                'genre_fk' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 4,
                'title' => 'Dune (volume 1)',
                'synopsis' => 'A stunning blend of adventure and mysticism, environmentalism, and politics, Dune is a powerful, fantastical tale that takes an unprecedented look into our universe, and is transformed by the graphic novel format. Frank Herbert’s epic science-fiction masterpiece set in the far future amidst a sprawling feudal interstellar society, Dune tells the story of Paul Atreides as he and his family accept control of the desert planet Arrakis.',
                'editorial' => 'Harry N. Abrams',
                'price' => 9.99,
                'image' => 'dune.jpg',
                'author' => 'Kevin j. Anderson',
                'genre_fk' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 5,
                'title' => 'The Lost Bookshop',
                'synopsis' => 'For too long, Opaline, Martha and Henry have been the side characters in their own lives. But when a vanishing bookshop casts its spell, these three unsuspecting strangers will discover that their own stories are every bit as extraordinary as the ones found in the pages of their beloved books. And by unlocking the secrets of the shelves, they find themselves transported to a world of wonder, where nothing is as it seems.',
                'editorial' => 'One More Chapter',
                'price' => 13.99,
                'image' => 'theLostBookshop.jpg',
                'author' => 'Evie Woods',
                'genre_fk' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 6,
                'title' => 'William',
                'synopsis' => 'Henry is a brilliant engineer who, after untold hours spent in his home lab, has achieved the breakthrough of his career—he’s created an artificially intelligent consciousness. He calls the half-formed robot William. No one knows about William. Henry’s agoraphobia keeps him inside the house, and his fixation on his project keeps him up in the attic, away from everyone, including his pregnant wife, Lily. When Lily’s coworkers show up, wanting to finally meet Henry and see the new house—the smartest of smart homes—Henry decides to introduce them to William, and things go from strange to much worse. Soon Henry and Lily discover the security upgrades intended to keep danger out of the house are even better at locking it in.',
                'editorial' => 'G.P. Putnams Sons',
                'price' => 24.30,
                'image' => 'william.jpg',
                'author' => 'Mason Coile',
                'genre_fk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 7,
                'title' => 'Then She Was Gone',
                'synopsis' => 'Ellie Mack was the perfect daughter. She was fifteen, the youngest of three. Beloved by her parents, friends, and teachers, and half of a teenaged golden couple. Ellie was days away from an idyllic post-exams summer vacation, with her whole life ahead of her. And then she was gone. Now, her mother Laurel Mack is trying to put her life back together. It’s been ten years since her daughter disappeared, seven years since her marriage ended, and only months since the last clue in Ellie’s case was unearthed. So when she meets an unexpectedly charming man in a café, no one is more surprised than Laurel at how quickly their flirtation develops into something deeper. Before she knows it, she’s meeting Floyd’s daughters—and his youngest, Poppy, takes Laurel’s breath away. Because looking at Poppy is like looking at Ellie. And now, the unanswered questions she’s tried so hard to put to rest begin to haunt Laurel anew. Where did Ellie go? Did she really run away from home, as the police have long suspected, or was there a more sinister reason for her disappearance? Who is Floyd, really? And why does his daughter remind Laurel so viscerally of her own missing girl?',
                'editorial' => 'Atria Books',
                'price' => 8.81,
                'image' => 'thenSheWasGone.jpg',
                'author' => 'Lisa Jewell',
                'genre_fk' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 8,
                'title' => 'The Coworker',
                'synopsis' => 'Two women. An office filled with secrets. One terrible crime that cant be taken back. Dawn Schiff is strange. At least, everyone thinks so at Vixed, the nutritional supplement company where Dawn works as an accountant. She never says the right thing. She has no friends. And she is always at her desk at precisely 8:45 a.m. So when Dawn doesnt show up to the office one morning, her coworker Natalie Farrell―beautiful, popular, top sales rep five years running―is surprised. Then she receives an unsettling, anonymous phone call that changes everything… It turns out Dawn wasnt just an awkward outsider―she was being targeted by someone close. And now Natalie is irrevocably tied to Dawn as she finds herself caught in a twisted game of cat and mouse that leaves her wondering: who is the real victim? But one thing is incredibly clear: somebody hated Dawn Schiff. Enough to kill.',
                'editorial' => 'Hollywood Upstairs Press',
                'price' => 13.48,
                'image' => 'theCoworker.jpg',
                'author' => 'Freida McFadden',
                'genre_fk' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 9,
                'title' => 'The Perfect Escape',
                'synopsis' => 'I’ve finally found the right guy. Tav takes care of me in a way that nobody ever has before. We’re both so busy with work that every moment together is priceless. But lately, there’s been a distance between us. This trip is the perfect chance for us to reconnect. He promised me a luxury weekend break. A state-of-the-art cabin surrounded by lush evergreen forest and snow-capped mountains. No cell service, no internet. Just the two of us. When we arrive, there’s a warm fire crackling in the corner and soft jazz playing from the speakers. It’s perfect. But I can’t escape the feeling I’m being watched. There’s a storm coming in. Tav goes down the mountain to stock up on provisions. The door clicks shut behind him. I try the doorknob. It won’t open. I’m locked in. And Tav is the one who’s trapped me here.',
                'editorial' => 'Joffe Books psychological thrillers, suspense and crime',
                'price' => 7.99,
                'image' => 'thePerfectEscape.jpg',
                'author' => 'Adriane Leigh',
                'genre_fk' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 10,
                'title' => 'The Notebook',
                'synopsis' => 'At thirty-one, Noah Calhoun, back in coastal North Carolina after World War II, is haunted by images of the girl he lost more than a decade earlier. At twenty-nine, socialite Allie Nelson is about to marry a wealthy lawyer, but she cannot stop thinking about the boy who long ago stole her heart. Thus begins the story of a love so enduring and deep it can turn tragedy into triumph, and may even have the power to create a miracle.',
                'editorial' => 'Grand Central Publishing',
                'price' => 17.05,
                'image' => 'theNotebook.jpg',
                'author' => 'Nicholas Sparks',
                'genre_fk' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 11,
                'title' => 'The Best of Me',
                'synopsis' => 'In the spring of 1984, high school students Amanda Collier and Dawson Cole fell deeply, irrevocably in love. Though they were from opposite sides of the tracks, their love for one another seemed to defy the realities of life in their small town in North Carolina. But as the summer of their senior year came to a close, unforeseen events would tear the young couple apart, setting them on radically divergent paths.',
                'editorial' => 'Grand Central Publishing',
                'price' => 8.99,
                'image' => 'theBestOfMe.jpg',
                'author' => 'Nicholas Sparks',
                'genre_fk' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 12,
                'title' => 'The Secrets We Keep',
                'synopsis' => 'Not much happens in Deerfield, Connecticut. The sleepy little town nestled at the foot of Taconic Range near two pristine lakes is the stuff of Hallmark movies. Picturesque town square, friendly neighbors, the changing seasons… but Deerfield’s small-town charm will lose its allure after a girl goes missing. Family secrets will be exposed, old wounds will be reopened, and lives will be turned upside down as past and present collide.',
                'editorial' => 'Grand Central Publishing',
                'price' => 15.99,
                'image' => 'theSecretsWeKeep.jpg',
                'author' => 'James Hunt',
                'genre_fk' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
