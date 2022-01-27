### Service d'email

Q2 : le client voudrait recevoir les emails envoyés de cette page contact **depuis** l'email saisie dans le formulaire (c'est-a-dire que l'email saisie dans le formulaire devienne l'expéditeur) avec son adresse email qui est "admin@mon-super-site.com". Cela permettra au client de répondre directement au visiteur en cliquant sur "Répondre" dans les emils qu'il recoit.

Q3 : le client souhaiterait, qu'à chaque demande de contact de la part d'un visiteur, qu'un email lui soit envoyé automatiquement avec le texte suivant :
```
Bonjour cher(e) visiteur,

Nous avons bien recu votre demande de contact et vous receverez une réponse dans les plus brefs délais.
Nous vous souhaitons une très belle journée et nous vous disons à très bientôt.

Cordialement,

L'équipe de www.mon-super-site.com
```

Q4 : Améliorer l'email en ajoutant des balises HTML (pour formatter l'email) et en ajoutant l'email du visiteur :
```
Bonjour cher(e) visiteur [email-visiteur@top.com],

Nous avons bien recu votre demande de contact et vous receverez une réponse dans les plus brefs délais.
Nous vous souhaitons une très belle journée et nous vous disons à très bientôt.

Cordialement,

L'équipe de www.mon-super-site.com
```
Attention, pour faire du bon dev, **respectez l'architecture MVC**.

Indice :
Pour ce faire, vous pourrez vous inspirez de : https://symfony.com/doc/current/mailer.html#html-content
Sachez que la class TemplateEmail hérite de la class Email, donc un TemplateEmail est un Email.
```
To define the contents of your email with Twig, use the TemplatedEmail class. This class extends the normal Email class but adds some new methods for Twig templates.
```

### Service de session

Q5 : utilisez le `RememberService` afin d'enregistrer l'email du visiteur lorsqu'il envoie une demande de contact, afin de pré-remplir le champs `email` du formulaire avec l'email précédemment saisi

Q6 : faite un refactoring du service `RememberService` afin d'utiliser un objet de type `RequestStack`.
Pour ce faire, il faudra récupérer les informations sur https://symfony.com/doc/current/session.html#basic-usage
pour votre analyse.


### Service d'upload de fichiers

Q7 : modifier l'entity `Bon` pour ajouter une propriété `imageFilename` (string, 255, nullable) et ajouter un champ `image` **non-mappé** dans le formType `BonType`.

Q8 : récupérer le service FileUploader de la documentation de Symfony : https://symfony.com/doc/5.4/controller/upload_file.html#creating-an-uploader-service

Demandez à Symfony d'injecter une valeur concrète pour le paramètre `$targetDirectory` en modifiant le fichier `config/services.yaml`

```
# config/services.yaml
services:
    # ...

    App\Service\FileUploader:
        arguments:
            $targetDirectory: '%kernel.project_dir%/public/uploads'
```

Q9 : utilisez le service dans le controller grâce à l'exemple dans la section `Now you're ready to use this service in the controller` dans la documentation précédente : https://symfony.com/doc/5.4/controller/upload_file.html#creating-an-uploader-service :

```php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

// ...
public function new(Request $request, FileUploader $fileUploader)
{
    // ...

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $brochureFile */
        $brochureFile = $form->get('brochure')->getData();
        if ($brochureFile) {
            $brochureFileName = $fileUploader->upload($brochureFile);
            $product->setBrochureFilename($brochureFileName);
        }

        // ...
    }

    // ...
}
```

**Avant de développer**, veuillez **analyser** ce code d'abord pour déterminer ce que vous allez coder.
Testez vos évolutions pour voir si cela fonctionne.

Q10 : afficher l'image des bons dans la vue `index.html.twig` en analysant cette partie de la documentation :
```
<a href="{{ asset('uploads/brochures/' ~ product.brochureFilename) }}">View brochure (PDF)</a>
```
Indice : a quoi sert la fonction TWIG `asset()` ? a quoi sert l'opérateur TWIG `~` ?