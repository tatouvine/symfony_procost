<?php

namespace App\DataFixtures;

use App\Entity\Src\Store\Brand;
use App\Entity\Src\Store\Color;
use App\Entity\Src\Store\Comment;
use App\Entity\Src\Store\Image;
use App\Entity\Src\Store\Product;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $manager;
    private $variableIdStockForComment = 13;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadUsers();
        $this->loadComments();
        $this->loadBrands();
        $this->loadColors();
        $this->loadProducts();
        $this->manager->flush();

        $manager->flush();
    }

    private function loadBrands(): void
    {
        $brands = [
            ["Adidas"],
            ["Asics"],
            ["Nike"],
            ["Puma"],
        ];

        foreach ($brands as $key => [$name]) {
            $brand = (new Brand())->setName((string)$name);
            $this->manager->persist($brand);
            $this->addReference(Brand::class . $key, $brand);
        }
    }

    private function loadComments(): void
    {
        var_dump("ici");
        $comments =
            [
                ["vzvartezvtarztrvzvtrtvzrzvrzrtv", new DateTime()],
                ["vzrvrztevtzrevztrevtzrtvrzetvzre", new DateTime()],
                ["tvzrezvrtzvtrztrvztvrezrvterztve", new DateTime()],
                ["vzrtezvrtezvtretrzvtzrvztrvvzrttrzvztrvtzrvtvzr", new DateTime()],
                ["ztvztrevtzrrztvzrtvzrtvzrtvzrtvrtvzev", new DateTime()],
                ["vvztrtzrvzrvtzvrtrztvtrvz", new DateTime()],
                ["ztvtzvrtvzrzrtvzrvtvrtzztvrzvtrzvtrezrtvzrtvzrtvzrtvervzte", new DateTime()],
                ["acareacercaercreacraeraceraeczrcaeacreraec", new DateTime()],
                ["ccraezcraezcraearcezracez", new DateTime()],
                ["ccraezcraezcraearcezracez", new DateTime()],
                ["ccraezcraezcraearcezracez", new DateTime()],
                ["ccraezcraezcraearcezracez", new DateTime()],
                ["ccraezcraezcraearcezracez", new DateTime()],
                ["ccraezcraezcraearcezracez", new DateTime()],
            ];

        foreach ($comments as $key => $oneComment) {
            $comment = (new Comment())->setMessage((string)$oneComment[0])
                ->setCreatedAt($oneComment[1]);
            $user = $this->getReference(User::class . random_int(0, 13));
            $comment->setUser($user);
            $this->manager->persist($comment);
            $this->addReference(Comment::class . $key, $comment);

        }
    }

    private function loadColors(): void
    {
        $colors = [
            ["jaune"],
            ["rose"],
            ["noir"],
            ["gris"],
            ["rouge"],
            ["vert"],
            ["bleu"],
            ["blanc"],
            ["noir"],
        ];
        foreach ($colors as $key => [$name]) {
            $color = (new Color())->setName((string)$name);
            $this->manager->persist($color);
            $this->addReference(Color::class . $key, $color);
        }
    }

    private function loadUsers(): void
    {
        $users =
            [
                ["user1", "123"],
                ["user2", "123"],
                ["user3", "123"],
                ["user4", "123"],
                ["user5", "123"],
                ["user6", "123"],
                ["user7", "123"],
                ["user8", "123"],
                ["user9", "123"],
                ["user10", "123"],
                ["user11", "123"],
                ["user12", "123"],
                ["user13", "123"],
                ["user14", "123"],
            ];
        foreach ($users as $key => $oneUser) {
            $user = (new User())->setUsername($oneUser[0])
                ->setRoles(['ROLE_USER']);
            $user->setPassword($this->encoder->encodePassword($user, $oneUser[1]));
            $this->manager->persist($user);
            $this->manager->persist($user);
            $this->addReference(User::class . $key, $user);
        }
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 15; $i++) {
            $product = (new Product())
                ->setId($i)
                ->setName('product ' . $i)
                ->setDescription("shot description du produit et c cool")
                ->setDescriptionLong('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                 do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
                   aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                     anim id est laborum.Produit de description ' . $i)
                ->setPrice(mt_rand(10, 100))
                ->setSlug("balbalblablalablalablablabla");

            $this->manager->persist($product);

            $image = (new Image())
                ->setUrl(sprintf('img/products/shoe-%d.jpg', $i))
                ->setAlt($product->getName());
            $product->setImage($image);
            $brand = $this->getReference(Brand::class . random_int(1, 3));
            $product->setBrand($brand);

            for ($j = 0; $j <= random_int(0, 3); $j++) {
                $color = $this->getReference(Color::class . random_int(0, 8));
                $product->addColor($color);
            }
            $i--;
            $comment = $this->getReference(Comment::class . $i);
            $i++;
            $product->addComment($comment);

            $condition = random_int(0, 1);
            while ($condition === 1) {
                $l = $this->generateComment();
                $comment = $this->getReference(Comment::class . $l);
                $product->addComment($comment);
                $condition = random_int(0, 1);
            }

            $this->manager->persist($product);
        }
    }

    private function generateComment(): ?int
    {
        $comment = (new Comment())->setMessage("Mon message et super cool")
            ->setCreatedAt(new DateTime()
            );

        $user = $this->getReference(User::class . random_int(0, 13));
        $comment->setUser($user);

        $this->manager->persist($comment);
        $this->variableIdStockForComment++;
        $this->addReference(Comment::class . $this->variableIdStockForComment, $comment);
        return $this->variableIdStockForComment;
    }
}
