<?php
namespace Application\Helper;

class ProduitHelper
{
    /**
     * 
     * @param integer $produitId
     * @return boolean false on fail | string url on success
     */
    public static function uploadImage($produitId)
    {
        // si ça se passe bien, on enregistre la photo en bdd
        // création du dossier pour les images du produit
        if (!is_dir(PUBLIC_PATH . '/images/photos/'.$produitId)) {
            mkdir(PUBLIC_PATH . '/images/photos/'.$produitId);
        }
        $dossier = PUBLIC_PATH . '/images/photos/'.$produitId.'/';
        
        $taille_maxi = 300000000;
        $taille = filesize($_FILES['url']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strtolower(strrchr($_FILES['url']['name'], '.'));

        $fichier = ProduitHelper::findImageName($extension, $dossier);
        
        //Début des vérifications de sécurité...
        if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
            $msg = 'Vous devez uploader un fichier de type png, jpg, jpeg...';
        }
        if ($taille > $taille_maxi) {
            $erreur = 'Le fichier est trop gros...';
        }
        if (!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
            if (move_uploaded_file($_FILES['url']['tmp_name'], $dossier . $fichier)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                // sauvegarde du fichier
                return 'images/photos/' . $produitId . '/' . $fichier;
            } else { //Sinon (la fonction renvoie FALSE).
                $msg = 'Echec de l\'upload !';
            }
        } else {
            return false;
        }
    }
    
    public static function findImageName($extension, $path)
    {
        $existingFiles = array();
        $dir = opendir($path); 
        while($file = readdir($dir)) {
            $existingFiles[] = $file;
        }
        do {
          $randName = rand(0, 100) . $extension;
        } while(in_array($randName, $existingFiles));
        
        return $randName;        
    }
    
    public static function deleteImagesFiles($idProduit)
    {
        $dir = PUBLIC_PATH . '/images/photos/'.$idProduit . '/';
        
        if (is_dir($dir)) {
            $dirHandler = opendir($dir);
            while ($file = readdir($dirHandler)) {
                if (!in_array($file, array('.', '..'))) {
                    unlink($dir.$file);
                }
            }
            rmdir($dir);
        }
    }
    
    public static function deleteImage($url)
    {
        if (is_file(PUBLIC_PATH . '/' . $url)) {
            return unlink (PUBLIC_PATH . '/' . $url);
        } else {
            return false;
        }
    }
}