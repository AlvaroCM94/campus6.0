<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use App\Form\AltaFormType;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordEncoderInterface;

class UsuarioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Usuario::class;
    }

    // public function configureCrud(Crud $crud): Crud {
    //     return $crud -> addFormTheme('base.html.twig');
    // }

    public function configureFields(string $pageName): iterable{

        yield IdField::new('id') -> onlyOnIndex();
        yield TextField::new('nombre');
        yield EmailField::new('email');
        yield ArrayField::new('roles') -> onlyOnIndex();
        yield TextField::new('password') -> onlyOnIndex();

    }

    public function configureActions(Actions $actions): Actions{
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setTemplatePath('admin/botonAltaAdmin.html.twig');
            })
        ;
    }

    // public function configureCrud(): Crud{
    //     return Crud::new()

    //         ->overrideTemplates([
    //             'crud/new' => 'admin/crearUsuario.html.twig'
    //         ])
    //     ;
    // }

    // public function createEntity(string $entityFqcn){
    //     $usuario = new Usuario();
    //     $form = $this->createForm(AltaFormType::class, $usuario);
    //     return $this->render('admin/crearUsuario.html.twig', ['usuario_form' => $form->createView()]);
    //     // return $this->render('web/travel-tech-skills/prueba.html.twig');
    // }

    // public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
    //     $this->encodePassword($entityInstance);
    //     parent::persistEntity($entityManager, $entityInstance);
    // }

    // public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
    //     $this->encodePassword($entityInstance);
    //     parent::updateEntity($entityManager, $entityInstance);
    // }

    // //private $passwordEncoder = new UserPasswordHasherInterface;
    // private function encodePassword(Usuario $user)
    // {
    //     //$passwordEncoder = new UserPasswordHasherInterface;
    //     if ($user->getPassword() !== null) {
    //         // $user->setSalt(base_convert(bin2hex(random_bytes(20)), 16, 36));
    //         // This is where you use UserPasswordEncoderInterface
    //         $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
    //     }
    // }
}
