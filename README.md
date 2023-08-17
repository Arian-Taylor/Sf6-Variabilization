# Symfony6 - Variabilization
Exemple d'utilisation d'un système de variabilisation d'un site sur un projet Symfony avec Webpack et JSX

## Requirement
- PHP version:
	- `>=8.1`

## Infos plugins
- Bootstrap: `^5.3.1`
- Jquery: `^3.7.0`

## Installation
- Installing dependancies :
	- `php composer.phar install`
	- `yarn install`
	- `yarn encore dev`
	- `yarn encore production`

- Update VE in the **.env** file :
	- `SYSTEM_SITE_VARIABILIZATION` : clé de variabilisation du site actuel, les valeur possible pour notre exemple `DEFAULT` ou `RED_SITE` ou `GREEN_SITE`

- Starting the server :
	- `symfony serve --port=8000`

## Testing URLs
- https://127.0.0.1:8000/test/variabilization/html/twig
- https://127.0.0.1:8000/test/variabilization/js/jsx