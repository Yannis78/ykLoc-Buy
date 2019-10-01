<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Yannis')
                  ->setLastName('Kecir')
                  ->setEmail('ysk78csp@gmail.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'yannis'))
                  ->setPicture('https://scontent-cdg2-1.cdninstagram.com/vp/d14ceb7fc3b695153b5a1b843a312be0/5E308BF4/t51.2885-19/s150x150/67609342_2411284952526511_5477076307428769792_n.jpg?_nc_ht=scontent-cdg2-1.cdninstagram.com')
                  ->setIntroduction('Je suis Yannis Kecir, 18 ans et milliardaire.')
                  ->setDescription("Je suis un milliardaire qui a fait fortune dans l'immobilier à Dubaï et Los Angeles en passant par New-York et Londres")
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);
        

        // Nous gérons les utilisateurs
        $users = [];
        $genres = ['male', 'female'];

        for($i = 1; $i <= 10; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                 ->setHash($hash)
                 ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }

        // Nous gérons les annonces

        for($i = 1; $i <= 30; $i++) {
            $ad = new Ad();


            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introdution = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)

            ->setCoverImage($coverImage)
            ->setIntrodution($introdution)
            ->setContent($content)
            ->setPrice(mt_rand(40,200))
            ->setRooms(mt_rand(1,6))
            ->setAuthor($user);


            for($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);

                      $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
