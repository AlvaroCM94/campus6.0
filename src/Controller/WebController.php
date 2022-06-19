<?php

namespace App\Controller;

use App\Entity\Curso;
use App\Entity\InstructorUsuario;
use App\Entity\Usuario;
use App\Entity\Lugares;
use App\Entity\Reserva;
use App\Form\AltaFormType;

use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Throwable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class WebController extends AbstractController
{

    //***************************************************** WEB CONTROLLERS *****************************************************

    public function navbar(): Response{

        return $this->render('components/navbar.html.twig');

    }

    public function home(): Response{

        return $this->render('web/home.html.twig');

    }

    public function softSkills(): Response{

        return $this->render('web/soft-skills.html.twig');

    }

    public function retos(): Response{

        return $this->render('web/retos.html.twig');

    }

    public function acompanamiento(): Response{

        return $this->render('web/acompanamiento.html.twig');

    }

    public function soluciones(): Response{

        return $this->render('web/soluciones-de-inteligencia.html.twig');

    }

    public function travelCrystalBall(): Response{

        return $this->render('web/travel-crystal-ball.html.twig');

    }

    public function contacto(EntityManagerInterface $em): Response{

        $error = "";

        try {

            $cursosActivos = $em->getRepository(Curso::class)->getAllCursos();
            //dd($cursosActivos[0]["nombre"]);

        } catch (Throwable $e) {

            echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/contacto.html.twig', [
                'contoller_name' => 'WebController', 'error' => $error, 'cursosActivos' => $cursosActivos
            ]);

        }

    }

    public function travelTechSkills(EntityManagerInterface $em): Response{

        try {

            $cursos = $em->getRepository(Curso::class)->getAllCursos();

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/travel-tech-skills/travel-tech-skills.html.twig', [
                'contoller_name' => 'WebController', 'cursos' => $cursos
            ]);

        }
    }

    public function infoDeCurso(): Response{

        return $this->render('web/travel-tech-skills/infoDeCurso.html.twig');

    }

    public function privacidad(): Response{

        return $this->render('web/privacidad.html.twig');

    }

    public function objetivos(EntityManagerInterface $em, int $id): Response{

        try {

            $objetivos = $em->getRepository(Curso::class)->objetivos($id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/travel-tech-skills/objetivos.html.twig', [
                'contoller_name' => 'WebController', 'objetivos' => $objetivos
            ]);

        }
    }

    public function competenciasBasicas(EntityManagerInterface $em, int $id): Response{

        try {

            $competenciasBasicas = $em->getRepository(Curso::class)->competenciasBasicas($id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/travel-tech-skills/competenciasBasicas.html.twig', [
                'contoller_name' => 'WebController', 'competenciasBasicas' => $competenciasBasicas
            ]);

        }
    }

    public function competenciasGenerales(EntityManagerInterface $em, int $id): Response{

        try {

            $competenciasGenerales = $em->getRepository(Curso::class)->competenciasGenerales($id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/travel-tech-skills/competenciasGenerales.html.twig', [
                'contoller_name' => 'WebController', 'competenciasGenerales' => $competenciasGenerales
            ]);

        }
    }

    public function competenciasEspecificas(EntityManagerInterface $em, int $id): Response{

        try {

            $competenciasEspecificas = $em->getRepository(Curso::class)->competenciasEspecificas($id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/travel-tech-skills/competenciasEspecificas.html.twig', [
                'contoller_name' => 'WebController', 'competenciasEspecificas' => $competenciasEspecificas
            ]);

        }
    }

    public function usuarios(EntityManagerInterface $em): Response{

        try {

            $prueba = $em->getRepository(Usuario::class)->usuarios();

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('web/travel-tech-skills/prueba.html.twig', [
                'contoller_name' => 'WebController', 'pruebas' => $prueba
            ]);

        }
    }

    // ****************************************************CAMPUS CONTROLLERS****************************************************


    // public function new(Request $request): Response{
    //     $usuario = new Usuario();

    //     // $form = $this->createFormBuilder($usuario)
    //     //     ->add('roles', TextType::class)
    //     //     ->add('password', PasswordType::class)
    //     //     ->add('email', TextType::class)
    //     //     ->getForm()
    //     // ;

    //     // return $this->renderForm('admin/crearUsuario.html.twig', [
    //     //     'form' => $form->createView(),
    //     // ]);

    //     $form = $this->createForm(AltaFormType::class, $usuario);

    //     return $this->renderForm('admin/crearUsuario.html.twig', [
    //         'form' => $form->createView(),
    //     ]);

    // }

    public function botonAltaAdmin(){

        return $this->render('admin/botonAltaAdmin.html.twig');
    }

    public function alta(){

        $usuario = new Usuario();
        $form = $this->createForm(AltaFormType::class, $usuario);

        return $this->render('admin/crearUsuario.html.twig', ['usuario_form' => $form->createView()]);

    }

    public function botonEditarAdmin(){

        return $this->render('admin/botonEditarAdmin.html.twig');
    }

    public function editar(){

        $usuario = new Usuario();
        $form = $this->createForm(EditarFormType::class, $usuario);

        return $this->render('admin/editarUsuario.html.twig', ['usuario_form' => $form->createView()]);

    }

    public function curso(){

        return $this->render('campus/Curso.html.twig');

    }

    public function infoCurso(EntityManagerInterface $em, $nombreC): Response{

        try {

            $infoCurso = $em->getRepository(Curso::class)->getCursoPorNombre($nombreC);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('campus/infoCurso.html.twig', ['curso' => $infoCurso]);

        }

    }



    public function uploadUser(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em){

        try {

            $email = $_POST["email"];
            $rol = $_POST["rol"];
            $rol = '["' . $rol . '"]';

            $contraseña = $_POST["password"];
            $aux = new Usuario();
            $cifrada = $passwordHasher->hashPassword($aux, $contraseña);

            $em->getRepository(Usuario::class)->altaUsuario($rol, $cifrada, $email);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            $usuario = new Usuario();
            $form = $this->createForm(AltaFormType::class, $usuario);
            return $this->render('admin/crearUsuario.html.twig', ['usuario_form' => $form->createView()]);

        }
    }

    public function editUser(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em){

        try {

            $email = $_POST["email"];

            $contraseña = $_POST["password"];
            $aux = new Usuario();
            $cifrada = $passwordHasher->hashPassword($aux, $contraseña);

            $em->getRepository(Usuario::class)->cambioContraUsuario($cifrada, $email);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->redirectToRoute('admin?crudAction=index&crudControllerFqcn=App\Controller\Admin\UsuarioCrudController&menuIndex=0&signature=rIQ1KTFnCZbuD1X6XAobVWz4WBjElofPpvQjaBN_ECM&submenuIndex=-1');
        
        }
    }

    public function campus(EntityManagerInterface $em): Response{

        try {

            $emailAux = $this->getUser()->getEmail();
            $idUser = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);
            //dd($idUser[0]['id']);
            $idCurso = $em->getRepository(Curso::class)->getAllCursosParaUnUsuario($idUser[0]['id']);
            //dd($idCurso);
            // if($idCurso == []){
            //     $idCurso = 0;
            // }
            //dd($idCurso[3]['id_curso_id']);
            $cursos = [];
            for ($i = 0; $i < sizeOf($idCurso); $i++) {
                $cursos[] = $em->getRepository(Curso::class)->getAllCursosPorId($idCurso[$i]['id_curso_id']);
            }
            //$cursos = $em->getRepository(Curso::class)->getAllCursosPorId($idCurso);
            //dd($cursos);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('campus/cursos.html.twig', [
                'contoller_name' => 'WebController', 'cursosAux' => $cursos
            ]);

        }
    }

    public function info(EntityManagerInterface $em, int $id): Response{

        try {

            $emailAux = $this->getUser()->getEmail();
            $idUser = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);
            $info = $em->getRepository(Curso::class)->getEstado($idUser[0]['id'], $id);
            
            $material = $em->getRepository(Curso::class)->materiales($id);

            $lugares = $em->getRepository(Lugares::class)->getAllLugares();

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {
            return $this->render('campus/estadoCurso.html.twig', [
                'contoller_name' => 'WebController', 'info' => $info[0]['estado'], 'materiales' => $material, 'lugares' => $lugares, 'idCurso' => $id
            ]);

        }
    }

    public function pasos(EntityManagerInterface $em, int $id): Response{

        try {

            $emailAux = $this->getUser()->getEmail();
            $idUser = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);
            $info = $em->getRepository(Curso::class)->getEstado($idUser[0]['id'], $id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('campus/pasos.html.twig', [
                'contoller_name' => 'WebController', 'info' => $info[0]['estado']
            ]);

        }
    }

    public function perfilInstructor(EntityManagerInterface $em): Response{

        try {

            $emailAux = $this->getUser()->getEmail();
            $idInstructor = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);

            $alumnosId = $em->getRepository(InstructorUsuario::class)->getAlumnosIdPorInstructorId($idInstructor[0]['id']);

            $alumnos = [];
            for ($i = 0; $i < sizeOf($alumnosId); $i++) {
                $alumnos[] = $em->getRepository(Usuario::class)->getAlumnosPorId($alumnosId[$i]['alumno_id']);
            }

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('instructor/perfilInstructor.html.twig', [
                'contoller_name' => 'WebController', 'alumnosAux' => $alumnos,
            ]);

        }
    }

    public function infoAlumno(EntityManagerInterface $em, int $id, string $nombre, array $alumno): Response{

        try {

            $cursosAlumnos = $em->getRepository(Curso::class)->getAllInfoCursosParaUnUsuario($id);

            $cursos = [];
            for ($i = 0; $i < sizeOf($cursosAlumnos); $i++) {
                $cursos[] = $em->getRepository(Curso::class)->getAllCursosPorId($cursosAlumnos[$i]['id_curso_id']);
            }

            $activos = [];
            for ($i = 0; $i < sizeOf($cursosAlumnos); $i++) {
                $activos[] = $em->getRepository(InstructorUsuario::class)->getUsuariosPorId($cursosAlumnos[$i]['id_usuario_id']);
            }

            $reservasAlumnos = $em->getRepository(Usuario::class)->getReservasAlumnosPorId($id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('instructor/infoAlumno.html.twig', [
                'contoller_name' => 'WebController', 'cursosAlumnos' => $cursosAlumnos, 'reservasAlumnos' => $reservasAlumnos,
                'cursosAux' => $cursos, 'nombre' => $nombre, 'alumno' => $alumno, 'activos' => $activos[0], 'idAlumno' => $id
            ]);

        }
    }

    public function infoAlumnoInactivo(EntityManagerInterface $em, int $id, string $nombre, array $alumno): Response{

        try {

            $cursosAlumnos = $em->getRepository(Curso::class)->getAllInfoCursosParaUnUsuario($id);

            $cursos = [];
            for ($i = 0; $i < sizeOf($cursosAlumnos); $i++) {
                $cursos[] = $em->getRepository(Curso::class)->getAllCursosPorId($cursosAlumnos[$i]['id_curso_id']);
            }

            $activos = [];
            for ($i = 0; $i < sizeOf($cursosAlumnos); $i++) {
                $activos[] = $em->getRepository(InstructorUsuario::class)->getUsuariosPorId($cursosAlumnos[$i]['id_usuario_id']);
            }

            $reservasAlumnos = $em->getRepository(Usuario::class)->getReservasAlumnosPorId($id);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('instructor/infoAlumnoNoActivo.html.twig', [
                'contoller_name' => 'WebController', 'cursosAlumnos' => $cursosAlumnos, 'reservasAlumnos' => $reservasAlumnos,
                'cursosAux' => $cursos, 'nombre' => $nombre, 'alumno' => $alumno, 'activos' => $activos[0]
            ]);

        }
    }

    public function modificarEstado(EntityManagerInterface $em): Response{

        $estado = $_POST["estado"];
        $id = $_POST["id"];

        try {

            $em->getRepository(Usuario::class)->modificarEstado($id, $estado);

            $emailAux = $this->getUser()->getEmail();

            $idInstructor = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);

            $alumnosId = $em->getRepository(InstructorUsuario::class)->getAlumnosIdPorInstructorId($idInstructor[0]['id']);
            $alumnos = [];

            for ($i = 0; $i < sizeOf($alumnosId); $i++) {
                $alumnos[] = $em->getRepository(Usuario::class)->getAlumnosPorId($alumnosId[$i]['alumno_id']);
            }

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('instructor/perfilInstructor.html.twig', [
                'contoller_name' => 'WebController', 'alumnosAux' => $alumnos,
            ]);

        }
    }

    public function reservar(EntityManagerInterface $em): Response{

        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];
        $reserva = $fecha . " " . $hora;
        $lugar = $_POST["lugar"];
        $idCurso = $_POST["idCurso"];

        try {

            $emailAux = $this->getUser()->getEmail();
            $id = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);

            $idLugar = $em->getRepository(Lugares::class)->getLugarIdPorNombre($lugar);

            $em->getRepository(Reserva::class)->addReserva($id[0]['id'], $reserva, $idLugar[0]['id'], $idCurso);

            $em->getRepository(Usuario::class)->modificarEstado($id[0]['id'], '3 Espera resultados autoevaluación');
            //dd('esto');

            $infoCurso = $em->getRepository(Curso::class)->getAllCursosPorId($idCurso[0]);
            //dd($infoCurso);

        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";

        } finally {

            return $this->render('campus/curso.html.twig', [ 'contoller_name' => 'WebController', 'curso' => $infoCurso[0], ]);

        }
    }

    public function contactoForm(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response{

        $error = "";

        $tipoInfo = $_POST["optradio"];

        $nombre = $_POST["nombre"];

        $rolAux = "ROLE_USER";
        $rol = '["' . $rolAux . '"]';

        $userAux = new Usuario();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.-';
        $contraseña = '';
        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $contraseña .= $characters[$index];
        }
        $password = $passwordHasher->hashPassword($userAux, $contraseña);

        $correo = $_POST["correo"];
        $apellidos = $_POST["apellidos"];
        $interes = $_POST["interes"];
        $telefono = $_POST["telefono"];

        if($_POST["comunicaciones"] == 'on'){
            $comunicaciones = 1;
        }else{
            $comunicaciones = 0;
        }

        if($_POST["datos"] == 'on'){
            $datos = 1;
        }else{
            $datos = 0;
        }

        $nombreApe = $nombre . " " . $apellidos;

        try {

            //dd($nombreApe, $rol, $password, $correo, $comunicaciones, $datos, $tipoInfo, $interes, $telefono);
            $em->getRepository(Usuario::class)->contactoForm($nombreApe, $rol, $password, $correo, $comunicaciones, $datos, $tipoInfo, $interes, $telefono);
            
        } catch (Throwable $e) {

            //echo "Error: " . $e . "<br>";
            
            $error = "Error en la creación del usuario, compruebe que el correo o el nombre utilizado no pertenezca ya a una cuenta en uso";

        } finally {

            $cursosActivos = $em->getRepository(Curso::class)->getAllCursos();

            return $this->render('web/contacto.html.twig', [
                'contoller_name' => 'WebController', 'error' => $error, 'cursosActivos' => $cursosActivos,
            ]);

        }
    }
}
