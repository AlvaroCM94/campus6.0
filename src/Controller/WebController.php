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

class WebController extends AbstractController{

    // *****************************************************WEB CONTROLLERS*****************************************************

    public function navbar():Response {
        return $this->render('components/navbar.html.twig');
        
    }

    public function home():Response {
        return $this->render('web/home.html.twig');
        
    }

    public function softSkills():Response {
        return $this->render('web/soft-skills.html.twig');
        
    }

    public function retos():Response {
        return $this->render('web/retos.html.twig');
        
    }

    public function acompanamiento():Response {
        return $this->render('web/acompanamiento.html.twig');
        
    }

    public function soluciones():Response {
        return $this->render('web/soluciones-de-inteligencia.html.twig');
        
    }

    public function travelCrystalBall():Response {
        return $this->render('web/travel-crystal-ball.html.twig');
        
    }

    public function contacto():Response {
        return $this->render('web/contacto.html.twig');
        
    }

    public function travelTechSkills(EntityManagerInterface $em):Response {
        try{

            $cursos = $em->getRepository(Curso::class)->getAllCursos();

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('web/travel-tech-skills/travel-tech-skills.html.twig', [
                'contoller_name' => 'WebController', 'cursos' => $cursos
            ]);
        }
        
    }

    public function infoDeCurso():Response {

        return $this->render('web/travel-tech-skills/infoDeCurso.html.twig');

    }

    public function objetivos(EntityManagerInterface $em, int $id):Response {
        try{
            $objetivos = $em->getRepository(Curso::class)->objetivos($id);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('web/travel-tech-skills/objetivos.html.twig', [
                'contoller_name' => 'WebController', 'objetivos' => $objetivos
            ]);
        }

    }

    public function competenciasBasicas(EntityManagerInterface $em, int $id):Response {
        try{
            $competenciasBasicas = $em->getRepository(Curso::class)->competenciasBasicas($id);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('web/travel-tech-skills/competenciasBasicas.html.twig', [
                'contoller_name' => 'WebController', 'competenciasBasicas' => $competenciasBasicas
            ]);
        }

    }

    public function competenciasGenerales(EntityManagerInterface $em, int $id):Response {
        try{
            $competenciasGenerales = $em->getRepository(Curso::class)->competenciasGenerales($id);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('web/travel-tech-skills/competenciasGenerales.html.twig', [
                'contoller_name' => 'WebController', 'competenciasGenerales' => $competenciasGenerales
            ]);
        }

    }

    public function competenciasEspecificas(EntityManagerInterface $em, int $id):Response {
        try{
            $competenciasEspecificas = $em->getRepository(Curso::class)->competenciasEspecificas($id);
        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('web/travel-tech-skills/competenciasEspecificas.html.twig', [
                'contoller_name' => 'WebController', 'competenciasEspecificas' => $competenciasEspecificas
            ]);
        }

    }

    public function usuarios(EntityManagerInterface $em):Response {
        try{
            $prueba = $em->getRepository(Usuario::class)->usuarios();

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
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
    
    
    public function uploadUser(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em){
        try{
            $email = $_POST["email"];
            $rol = $_POST["rol"]; $rol = '["' . $rol . '"]';
    
            $contraseña = $_POST["password"];
            $aux = new Usuario();
            $cifrada = $passwordHasher->hashPassword($aux, $contraseña);

            $em->getRepository(Usuario::class)->altaUsuario($rol, $cifrada, $email);
    
        }catch(Throwable $e){
            echo "Error: " . $e . "<br>";
    
        }finally{
            $usuario = new Usuario();
            $form = $this->createForm(AltaFormType::class, $usuario);
            return $this->render('admin/crearUsuario.html.twig', ['usuario_form' => $form->createView()]);
        }
    }

    public function campus(EntityManagerInterface $em):Response {
        try{
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
            for($i = 0; $i < sizeOf($idCurso); $i++){
                $cursos[] = $em->getRepository(Curso::class)->getAllCursosPorId($idCurso[$i]['id_curso_id']);
            }
            //$cursos = $em->getRepository(Curso::class)->getAllCursosPorId($idCurso);
            //dd($cursos);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('campus/cursos.html.twig', [
                'contoller_name' => 'WebController', 'cursosAux' => $cursos
            ]);
        }
    }

    public function infoCurso():Response {

        return $this->render('campus/infoCurso.html.twig');

    }

    public function info(EntityManagerInterface $em, int $id):Response {
        try{
            $emailAux = $this->getUser()->getEmail();
            $idUser = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);
            $info = $em->getRepository(Curso::class)->getEstado($idUser[0]['id'], $id);

            $material = $em->getRepository(Curso::class)->materiales($id);

            $lugares = $em->getRepository(Lugares::class)->getAllLugares();

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('campus/estadoCurso.html.twig', [
                'contoller_name' => 'WebController', 'info' => $info[0]['estado'], 'materiales' => $material, 'lugares' => $lugares,
            ]);
        }
    }

    public function perfilInstructor(EntityManagerInterface $em):Response {
        try{
            $emailAux = $this->getUser()->getEmail();
            $idInstructor = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);

            $alumnosId = $em->getRepository(InstructorUsuario::class)->getAlumnosIdPorInstructorId($idInstructor[0]['id']);
            //dd($alumnosId);

            $alumnos = [];
            for($i = 0; $i < sizeOf($alumnosId); $i++){
                $alumnos[] = $em->getRepository(Usuario::class)->getAlumnosPorId($alumnosId[$i]['alumno_id']);
            }
            //dd($alumnos);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('instructor/perfilInstructor.html.twig', [
                'contoller_name' => 'WebController', 'alumnosAux' => $alumnos,
            ]);
        }
    }

    public function infoAlumno(EntityManagerInterface $em, int $id, string $nombre, array $alumno):Response {
        try{
            $cursosAlumnos = $em->getRepository(Curso::class)->getAllInfoCursosParaUnUsuario($id);

            $cursos = [];
            for($i = 0; $i < sizeOf($cursosAlumnos); $i++){
                $cursos[] = $em->getRepository(Curso::class)->getAllCursosPorId($cursosAlumnos[$i]['id_curso_id']);
            }
            
            $activos = [];
            for($i = 0; $i < sizeOf($cursosAlumnos); $i++){
                $activos[] = $em->getRepository(InstructorUsuario::class)->getUsuariosPorId($cursosAlumnos[$i]['id_usuario_id']);
            }

            $reservasAlumnos = $em->getRepository(Usuario::class)->getReservasAlumnosPorId($id);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('instructor/infoAlumno.html.twig', [
                'contoller_name' => 'WebController', 'cursosAlumnos' => $cursosAlumnos, 'reservasAlumnos' => $reservasAlumnos,
                'cursosAux' => $cursos, 'nombre' => $nombre, 'alumno' => $alumno, 'activos' => $activos[0], 'idAlumno' => $id
            ]);
        }
    }

    public function infoAlumnoInactivo(EntityManagerInterface $em, int $id, string $nombre, array $alumno):Response {
        try{
            $cursosAlumnos = $em->getRepository(Curso::class)->getAllInfoCursosParaUnUsuario($id);

            $cursos = [];
            for($i = 0; $i < sizeOf($cursosAlumnos); $i++){
                $cursos[] = $em->getRepository(Curso::class)->getAllCursosPorId($cursosAlumnos[$i]['id_curso_id']);
            }
            
            $activos = [];
            for($i = 0; $i < sizeOf($cursosAlumnos); $i++){
                $activos[] = $em->getRepository(InstructorUsuario::class)->getUsuariosPorId($cursosAlumnos[$i]['id_usuario_id']);
            }

            $reservasAlumnos = $em->getRepository(Usuario::class)->getReservasAlumnosPorId($id);

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('instructor/infoAlumnoNoActivo.html.twig', [
                'contoller_name' => 'WebController', 'cursosAlumnos' => $cursosAlumnos, 'reservasAlumnos' => $reservasAlumnos,
                'cursosAux' => $cursos, 'nombre' => $nombre, 'alumno' => $alumno, 'activos' => $activos[0]
            ]);
        }
    }

    public function modificarEstado(EntityManagerInterface $em):Response {

        $estado = $_POST["estado"];
        $id = $_POST["id"];
        
        try{
            $em->getRepository(Usuario::class)->modificarEstado($id, $estado);
            
            $emailAux = $this->getUser()->getEmail();

            $idInstructor = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);

            $alumnosId = $em->getRepository(InstructorUsuario::class)->getAlumnosIdPorInstructorId($idInstructor[0]['id']);
            $alumnos = [];
            
            for($i = 0; $i < sizeOf($alumnosId); $i++){
                $alumnos[] = $em->getRepository(Usuario::class)->getAlumnosPorId($alumnosId[$i]['alumno_id']);
            }

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('instructor/perfilInstructor.html.twig', [
                'contoller_name' => 'WebController', 'alumnosAux' => $alumnos,
            ]);
        }
    }

    public function reservar(EntityManagerInterface $em):Response {

        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];
        $lugar = $_POST["lugar"];

        dd($fecha, $hora);
        
        try{
            $emailAux = $this->getUser()->getEmail();
            $id = $em->getRepository(Usuario::class)->getUsuarioPorEmail($emailAux);

            $em->getRepository(Reserva::class)->addReserva($fecha,);
            
            

        } catch(Throwable $e){

            echo "Error: " . $e . "<br>";

        } finally{
            return $this->render('campus/infoCurso.html.twig');
        }
    }





}
