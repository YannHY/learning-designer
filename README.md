# learning-designer-revised
Interface dérivée de UCL Learning Designer.

➜ [https://jourde.github.io/learning-designer-revised/index.html](https://jourde.github.io/learning-designer-revised/index.html)

- [Guide d'utilisation](https://jourde.github.io/learning-designer-revised/guide-fr.md)

## Comptes et sauvegarde

Le projet peut maintenant être déployé sur un hébergement PHP avec base MySQL pour permettre :

- la création d'un premier compte administrateur via `setup_admin.php`
- la connexion des utilisateurs via `login.php`
- la sauvegarde des productions dans la table `learning_designs`
- le chargement et la suppression des productions depuis l'interface

### Configuration

Laisser [app-config.php](/Users/rene/Documents/claude/learning-designer-revised/app-config.php) comme gabarit, puis renseigner les accès réels dans [learning-design-secret.php](/Users/rene/Documents/claude/learning-designer-revised/learning-design-secret.php) :

- `APP_DB_DSN`
- `APP_DB_USER`
- `APP_DB_PASS`
- `APP_BASE_URL`

Les tables nécessaires sont créées automatiquement au premier accès.
