<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true, nullable:true)]
    private $nombre;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $email;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: UsuarioCurso::class)]
    private $usuarioCursos;

    #[ORM\OneToMany(mappedBy: 'instructor', targetEntity: InstructorUsuario::class)]
    private $instructor;

    #[ORM\OneToMany(mappedBy: 'alumno', targetEntity: InstructorUsuario::class)]
    private $alumno;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: Reserva::class)]
    private $reservas;

    #[ORM\OneToOne(mappedBy: 'id_alumno', targetEntity: Chat::class, cascade: ['persist', 'remove'])]
    private $chat_alumno;

    #[ORM\OneToMany(mappedBy: 'id_instructor', targetEntity: Chat::class)]
    private $chat_instructor;

    public function __construct()
    {
        $this->usuarioCursos = new ArrayCollection();
        $this->instructor = new ArrayCollection();
        $this->alumno = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->chat_instructor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->nombre;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->nombre;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';
            
        // $roles = [
        //     'ROLE_USER' => 'ROLE_USER',
        //     'ROLE_ADMIN' => 'ROLE_ADMIN'
        // ];

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self{
        
        $this->password = $password;
        //$this->password = $this->setPasswordEncoded($password);

        return $this;
    }

    public function setPasswordEncoded(string $password, UserPasswordHasherInterface $passwordHasher){
        $user = new Usuario();

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);

    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id . " - " . $this->nombre;
    }

    /**
     * @return Collection<int, UsuarioCurso>
     */
    public function getUsuarioCursos(): Collection
    {
        return $this->usuarioCursos;
    }

    public function addUsuarioCurso(UsuarioCurso $usuarioCurso): self
    {
        if (!$this->usuarioCursos->contains($usuarioCurso)) {
            $this->usuarioCursos[] = $usuarioCurso;
            $usuarioCurso->setIdUsuario($this);
        }

        return $this;
    }

    public function removeUsuarioCurso(UsuarioCurso $usuarioCurso): self
    {
        if ($this->usuarioCursos->removeElement($usuarioCurso)) {
            // set the owning side to null (unless already changed)
            if ($usuarioCurso->getIdUsuario() === $this) {
                $usuarioCurso->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InstructorUsuario>
     */
    public function getInstructor(): Collection
    {
        return $this->instructor;
    }

    public function addInstructor(InstructorUsuario $instructor): self
    {
        if (!$this->instructor->contains($instructor)) {
            $this->instructor[] = $instructor;
            $instructor->setInstructor($this);
        }

        return $this;
    }

    public function removeInstructor(InstructorUsuario $instructor): self
    {
        if ($this->instructor->removeElement($instructor)) {
            // set the owning side to null (unless already changed)
            if ($instructor->getInstructor() === $this) {
                $instructor->setInstructor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InstructorUsuario>
     */
    public function getAlumno(): Collection
    {
        return $this->alumno;
    }

    public function addAlumno(InstructorUsuario $alumno): self
    {
        if (!$this->alumno->contains($alumno)) {
            $this->alumno[] = $alumno;
            $alumno->setAlumno($this);
        }

        return $this;
    }

    public function removeAlumno(InstructorUsuario $alumno): self
    {
        if ($this->alumno->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getAlumno() === $this) {
                $alumno->setAlumno(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): self
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas[] = $reserva;
            $reserva->setIdUsuario($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getIdUsuario() === $this) {
                $reserva->setIdUsuario(null);
            }
        }

        return $this;
    }

    public function getChatAlumno(): ?Chat
    {
        return $this->chat_alumno;
    }

    public function setChatAlumno(Chat $chat_alumno): self
    {
        // set the owning side of the relation if necessary
        if ($chat_alumno->getIdAlumno() !== $this) {
            $chat_alumno->setIdAlumno($this);
        }

        $this->chat_alumno = $chat_alumno;

        return $this;
    }

    /**
     * @return Collection<int, Chat>
     */
    public function getChatInstructor(): Collection
    {
        return $this->chat_instructor;
    }

    public function addChatInstructor(Chat $chatInstructor): self
    {
        if (!$this->chat_instructor->contains($chatInstructor)) {
            $this->chat_instructor[] = $chatInstructor;
            $chatInstructor->setIdInstructor($this);
        }

        return $this;
    }

    public function removeChatInstructor(Chat $chatInstructor): self
    {
        if ($this->chat_instructor->removeElement($chatInstructor)) {
            // set the owning side to null (unless already changed)
            if ($chatInstructor->getIdInstructor() === $this) {
                $chatInstructor->setIdInstructor(null);
            }
        }

        return $this;
    }

}
