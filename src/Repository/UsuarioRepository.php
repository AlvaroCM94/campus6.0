<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<Usuario>
 *
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function add(Usuario $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Usuario $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Usuario) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function usuarios(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM usuario";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function altaUsuario($rol, $cifrada, $email){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO usuario (roles, password, email)
        VALUES ('$rol', '$cifrada', '$email')";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function cambioContraUsuario($cifrada, $email){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE usuario SET password = '$cifrada' WHERE email = '$email'";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getUsuarioPorEmail($email){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id FROM usuario WHERE email='$email'";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getAlumnosPorId($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM usuario WHERE id='$id'";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getReservasAlumnosPorId($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM reserva WHERE id_usuario_id='$id'";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function modificarEstado($id, $estado){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE usuario_curso SET estado = '$estado' WHERE id_usuario_id = '$id'";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function contactoForm($nombreApe, $rol, $password, $correo, $comunicaciones, $datos, $tipoInfo, $interes, $telefono){

        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO usuario (nombre, roles, password, email, comunicaciones, procesar_almacenar_datos, tramitado, info_inscripcion, areas_interes, telefono)
        VALUES ('$nombreApe', '$rol', '$password', '$correo', '$comunicaciones', '$datos', '0', '$tipoInfo', '$interes', '$telefono')";
        
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }


//    /**
//     * @return Usuario[] Returns an array of Usuario objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Usuario
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
