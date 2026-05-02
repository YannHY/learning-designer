# learning-designer-revised
Interface dérivée de UCL Learning Designer.

➜ [https://jourde.github.io/learning-designer-revised/interface.html](https://jourde.github.io/learning-designer-revised/interface.html)

- [Guide d'utilisation](https://jourde.github.io/learning-designer-revised/guide-fr.md)

## Comptes et sauvegarde

Le projet peut maintenant être déployé sur un hébergement PHP avec base MySQL pour permettre :

- la création d'un premier compte administrateur via `setup_admin.php`
- la connexion des utilisateurs via `login.php`
- la sauvegarde des productions dans la table `learning_designs`
- le chargement et la suppression des productions depuis l'interface

### Configuration

Renseigner les accès base de données dans [app-config.php](/Users/rene/Documents/claude/learning-designer-revised/app-config.php) :

- `APP_DB_DSN`
- `APP_DB_USER`
- `APP_DB_PASS`
- `APP_BASE_URL`

Les tables nécessaires sont créées automatiquement au premier accès.
