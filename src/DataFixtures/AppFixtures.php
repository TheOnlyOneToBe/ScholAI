<?php

namespace App\DataFixtures;

use App\Entity\AnneeAcademique;
use App\Entity\AntecedentAcademique;
use App\Entity\Bourse;
use App\Entity\Campus;
use App\Entity\ChefDepartement;
use App\Entity\Cours;
use App\Entity\Cycle;
use App\Entity\Departement;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use App\Entity\Filiere;
use App\Entity\FiliereCycle;
use App\Entity\ImpressionFormat;
use App\Entity\Incident;
use App\Entity\Inscription;
use App\Entity\Note;
use App\Entity\Payementmethod;
use App\Entity\Payementreason;
use App\Entity\PlanningCours;
use App\Entity\Presence;
use App\Entity\Professeur;
use App\Entity\Reglement;
use App\Entity\Role;
use App\Entity\SalleCours;
use App\Entity\Semestre;
use App\Entity\TuteurEtudiant;
use App\Entity\TypeEvaluation;
use App\Entity\UE;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Enum\Genre;
use App\Enum\GraviteIncident;
use App\Enum\StatutInscription;
use App\Enum\StatutPresence;
use App\Enum\TypeAvertissement;
use App\Enum\TypeTuteur;

class AppFixtures extends Fixture
{
    private $faker;
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = \Faker\Factory::create('fr_FR');
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Création des rôles
        $roleNames = ['ROLE_ADMIN', 'ROLE_PROF', 'ROLE_ETUDIANT'];
        $roles = [];
        
        foreach ($roleNames as $roleName) {
            $role = new Role();
            $role->setNomRole($roleName);
            $manager->persist($role);
            $roles[$roleName] = $role;
        }

        // 2. Création des campus
        $campuses = [];
        $campusNames = ['Campus Principal', 'Campus Annexe', 'Campus Nord', 'Campus Sud'];
        
        foreach ($campusNames as $campusName) {
            $campus = new Campus();
            $campus->setNomCampus($campusName)
                  ->setAdresseCampus($this->faker->address());
            $manager->persist($campus);
            $campuses[] = $campus;
        }

        // 3. Création de l'année académique
        $anneeActive = new AnneeAcademique();
        $anneeActive->setYearStart(new \DateTime('2023-09-01'))
                   ->setYearEnd(new \DateTime('2024-07-31'))
                   ->setCurrent(true);
        $manager->persist($anneeActive);

        // 4. Création des départements
        $departements = [];
        $deptNames = ['Informatique', 'Génie Civil', 'Électronique', 'Management', 'Communication'];
        
        foreach ($deptNames as $deptName) {
            $departement = new Departement();
            $departement->setNomDepartement($deptName)
                       ->setDateCreation($this->faker->dateTimeBetween('-5 years', 'now'));
            $manager->persist($departement);
            $departements[] = $departement;
        }

        // 5. Création des cycles
        $cycles = [];
        $cycleNames = ['Licence', 'Master', 'Doctorat'];

        foreach ($cycleNames as $name) {
            $cycle = new Cycle();
            $cycle->setNomCycle($name);
            $manager->persist($cycle);
            $cycles[] = $cycle;
        }

        // 6. Création des filières
        $filieres = [];
        $filiereNames = [
            'Génie Logiciel',
            'Réseaux et Télécommunications',
            'Systèmes Embarqués',
            'Intelligence Artificielle',
            'Sécurité Informatique'
        ];

        foreach ($filiereNames as $name) {
            $filiere = new Filiere();
            $filiere->setNomFiliere($name);
            $manager->persist($filiere);
            $filieres[] = $filiere;
        }

        // 7. Création des semestres
        $semestres = [];
        $semDates = [
            ['S1', '2023-09-01', '2024-01-31'],
            ['S2', '2024-02-01', '2024-06-30']
        ];

        foreach ($semDates as [$num, $debut, $fin]) {
            $semestre = new Semestre();
            $semestre->setNumSemestre($num)
                    ->setDateDebut(new \DateTime($debut))
                    ->setDateFin(new \DateTime($fin))
                    ->setAnneeacademique($anneeActive);
            $manager->persist($semestre);
            $semestres[] = $semestre;
        }

        // 8. Création des cours
        $cours = [];
        $coursNames = [
            'Programmation Orientée Objet' => 'CM',
            'Bases de données' => 'CM',
            'Réseaux' => 'CM',
            'Algorithmique' => 'TD',
            'Développement Web' => 'TP'
        ];

        foreach ($coursNames as $nom => $type) {
            $cours_item = new Cours();
            $cours_item->setNomCours($nom)
                      ->setDescriptif("Description de " . $nom)
                      ->setTypeCours($type);
            $manager->persist($cours_item);
            $cours[] = $cours_item;
        }

        // 9. Création des professeurs
        $professeurs = [];
        for ($i = 0; $i < 20; $i++) {
            $professeur = new Professeur();
            $professeur->setNom($this->faker->lastName())
                      ->setPrenom($this->faker->firstName())
                      ->setEmail($this->faker->email())
                      ->setNumeroTelephone($this->faker->phoneNumber())
                      ->setCni($this->faker->regexify('[A-Z0-9]{8}'))
                      ->setDateNaissance($this->faker->dateTimeBetween('-60 years', '-25 years'))
                      ->setNationalite('Camerounaise')
                      ->setSexe($this->faker->randomElement(['M', 'F']))
                      ->setAdresse($this->faker->address())
                      ->setDateCreation(new \DateTime())
                      ->setDateModification(new \DateTime());
            $manager->persist($professeur);
            $professeurs[] = $professeur;
        }

        // 10. Création des UEs
        $ues = [];
        foreach ($semestres as $semestre) {
            foreach ($cours as $cours_item) {
                $ue = new UE();
                $ue->setSemestre($semestre)
                   ->setMatiere($cours_item)
                   ->setProfeseur($this->faker->randomElement($professeurs))
                   ->setVolumeHoraire($this->faker->numberBetween(30, 60))
                   ->setStatut('Planifié');
                $manager->persist($ue);
                $ues[] = $ue;
            }
        }

        // 11. Création des types d'évaluation
        $typeEvals = [];
        $typeNames = ['Contrôle Continu', 'Examen Final', 'TP', 'Projet', 'Rattrapage'];
        
        foreach ($typeNames as $name) {
            $typeEval = new TypeEvaluation();
            $typeEval->setTitre($name);
            $manager->persist($typeEval);
            $typeEvals[] = $typeEval;
        }

        // 12. Création des salles de cours
        $salles = [];
        foreach ($campuses as $campus) {
            for ($i = 1; $i <= 5; $i++) {
                $salle = new SalleCours();
                $salle->setNomSalle("Salle " . $i)
                      ->setCapacite($this->faker->numberBetween(30, 100))
                      ->setCampus($campus);
                $manager->persist($salle);
                $salles[] = $salle;
            }
        }

        // 13. Création des filière-cycles
        $filiereCycles = [];
        foreach ($filieres as $filiere) {
            foreach ($cycles as $cycle) {
                $filiereCycle = new FiliereCycle();
                $filiereCycle->setFiliere($filiere)
                            ->setCycle($cycle)
                            ->setDescription("Programme de " . $filiere->getNomFiliere() . " en " . $cycle->getNomCycle())
                            ->setFraisInscription($this->faker->numberBetween(300000, 1000000));
                $manager->persist($filiereCycle);
                $filiereCycles[] = $filiereCycle;
            }
        }

        // 14. Création des évaluations
        foreach ($ues as $ue) {
            foreach ($typeEvals as $type) {
                $evaluation = new Evaluation();
                $evaluation->setUE($ue)
                          ->setSemestre($ue->getSemestre())
                          ->setDateDebut($this->faker->dateTimeBetween('+1 month', '+3 months'))
                          ->setTempsEvaluation($this->faker->numberBetween(60, 180))
                          ->setStatut('Planifié')
                          ->setType($type);
                $manager->persist($evaluation);
            }
        }

        // 15. Création des étudiants et leurs antécédents académiques
        $etudiants = [];
        for ($i = 0; $i < 100; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNom($this->faker->lastName())
                    ->setPrenom($this->faker->firstName())
                    ->setDateNaissance($this->faker->dateTimeBetween('-25 years', '-18 years'))
                    ->setLieuNaissance($this->faker->city())
                    ->setAdresse($this->faker->address())
                    ->setEmail($this->faker->email())
                    ->setNumTelephone($this->faker->phoneNumber())
                    ->setSexe($this->faker->randomElement(['M', 'F']))
                    ->setNationalite('Camerounaise')
                    ->setRegistrationAllowed(true)
                    ->setDateCreation(new \DateTime())
                    ->setDateModification(new \DateTime());
            $manager->persist($etudiant);
            $etudiants[] = $etudiant;

            // Création d'antécédents académiques pour chaque étudiant
            $antecedent = new AntecedentAcademique();
            $antecedent->setEtudiant($etudiant)
                      ->setEtablissement($this->faker->company())
                      ->setDiplome($this->faker->randomElement(['BAC', 'BTS', 'DUT', 'Licence']))
                      ->setMatriculeDiplome($this->faker->regexify('[A-Z0-9]{10}'))
                      ->setAnneeObtention($this->faker->dateTimeBetween('-5 years', '-1 year'));
            $manager->persist($antecedent);

            // Attribution de bourses à certains étudiants (30% de chance)
            if ($this->faker->boolean(30)) {
                $bourse = new Bourse();
                $bourse->setEtudiant($etudiant)
                       ->setMontant($this->faker->numberBetween(100000, 500000))
                       ->setRemise($this->faker->numberBetween(0, 50));
                $manager->persist($bourse);
            }
        }

        // 16. Création des chefs de département
        foreach ($departements as $departement) {
            $chefDept = new ChefDepartement();
            $chefDept->setProfesseur($this->faker->randomElement($professeurs))
                    ->setDepartement($departement)
                    ->setDateDebutMandat($this->faker->dateTimeBetween('-2 years', 'now'));
            $manager->persist($chefDept);
        }

        // 17. Création des inscriptions
        $inscriptions = [];
        foreach ($etudiants as $etudiant) {
            $inscription = new Inscription();
            $inscription->setEtudiant($etudiant)
                       ->setSemestre($this->faker->randomElement($semestres))
                       ->setFiliereCycle($this->faker->randomElement($filiereCycles))
                       ->setDateInscription(new \DateTime())
                       ->setStatut($this->faker->randomElement(StatutInscription::cases()))
                       ->setSuspended(false)
                       ->setAnnee($anneeActive);
            $manager->persist($inscription);
            $inscriptions[] = $inscription;
        }

        // 18. Création des notes
        foreach ($etudiants as $etudiant) {
            foreach ($ues as $ue) {
                foreach ($typeEvals as $typeEval) {
                    if ($this->faker->boolean(70)) { // 70% de chance d'avoir une note
                        $note = new Note();
                        $note->setEtudiant($etudiant)
                             ->setEvaluation($evaluation)
                             ->setNoteValue($this->faker->numberBetween(0, 20));
                        $manager->persist($note);
                    }
                }
            }
        }

        // 19. Création des plannings de cours
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $plannings = [];
        foreach ($ues as $ue) {
            for ($i = 0; $i < 3; $i++) { // 3 séances par UE
                $heureDebut = new \DateTime('08:00:00');
                $heureDebut->modify('+' . $this->faker->numberBetween(0, 8) . ' hours');
                
                $heureFin = clone $heureDebut;
                $heureFin->modify('+2 hours');

                $planning = new PlanningCours();
                $planning->setUE($ue)
                        ->setSalleCours($this->faker->randomElement($salles))
                        ->setJour($this->faker->randomElement($jours))
                        ->setHeureDebut($heureDebut)
                        ->setHeureFin($heureFin);
                $manager->persist($planning);
                $plannings[] = $planning;
            }
        }

        // 20. Création des présences
        foreach ($etudiants as $etudiant) {
            foreach ($plannings as $planning) {
                if ($this->faker->boolean(80)) { // 80% de chance d'être présent
                    $presence = new Presence();
                    $presence->setEtudiant($etudiant)
                            ->setUE($planning->getUE())
                            ->setPlanningCours($planning)
                            ->setStatut($this->faker->randomElement(StatutPresence::cases()));
                    $manager->persist($presence);
                }
            }
        }

        // 21. Création des tuteurs
        foreach ($etudiants as $etudiant) {
            $tuteur = new TuteurEtudiant();
            $tuteur->setEtudiant($etudiant)
                   ->setNom($this->faker->lastName())
                   ->setPrenom($this->faker->firstName())
                   ->setSexe($this->faker->randomElement(Genre::cases()))
                   ->setNumTelephone($this->faker->numerify('+237########'))
                   ->setTypeTuteur($this->faker->randomElement(TypeTuteur::cases()));
            $manager->persist($tuteur);
        }

        // 22. Création des formats d'impression
        $formatNames = [
            'A4' => ['210mm', 297],
            'A3' => ['297mm', 420],
            'Letter' => ['216mm', 279]
        ];

        foreach ($formatNames as $name => [$largeur, $longueur]) {
            $format = new ImpressionFormat();
            $format->setNomFormat($name)
                   ->setLargeurPage($largeur)
                   ->setLongueurPage($longueur)
                   ->setDescription("Format standard " . $name);
            $manager->persist($format);
        }

        // 23. Création des méthodes de paiement
        $methodesNames = ['Espèces', 'Chèque', 'Virement bancaire', 'Mobile Money', 'Carte bancaire'];
        $methodes = [];
        
        foreach ($methodesNames as $name) {
            $methode = new Payementmethod();
            $methode->setPayementName($name);
            $manager->persist($methode);
            $methodes[] = $methode;
        }

        // 24. Création des raisons de paiement
        $payementReasons = [];
        $raisons = ['Frais de scolarité', 'Frais d\'inscription', 'Frais d\'examen', 'Frais de bibliothèque'];
        foreach ($raisons as $raison) {
            $payementReason = new Payementreason();
            $payementReason->setRaison($raison);
            $manager->persist($payementReason);
            $payementReasons[] = $payementReason;
        }

        // 25. Création des règlements
        foreach ($inscriptions as $inscription) {
            foreach ($payementReasons as $reason) {
                if ($this->faker->boolean(70)) { // 70% de chance d'avoir un règlement
                    $reglement = new Reglement();
                    $reglement->setInscription($inscription)
                             ->setLibelleReglement($reason)
                             ->setPayementmethod($this->faker->randomElement($methodes))
                             ->setMontantReglee($this->faker->numberBetween(50000, 200000))
                             ->setDatereglement($this->faker->dateTimeBetween('-6 months', 'now'));
                    $manager->persist($reglement);
                }
            }
        }

        // 26. Création des incidents
        foreach ($etudiants as $etudiant) {
            if ($this->faker->boolean(30)) { // 30% de chance d'avoir un incident
                $incident = new Incident();
                $incident->setEtudiant($etudiant)
                        ->setDescription($this->faker->sentence())
                        ->setDateIncident($this->faker->dateTimeBetween('-6 months', 'now'))
                        ->setGravite($this->faker->randomElement(GraviteIncident::cases()))
                        ->setTypeIncident($this->faker->randomElement(TypeAvertissement::cases()));
                $manager->persist($incident);
            }
        }

        $manager->flush();
    }
}