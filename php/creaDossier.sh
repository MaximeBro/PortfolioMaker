#!/bin/bash

echo "Création des dossiers pour le client $1"
# Vérification que le nom de dossier a été fourni
if [ $# -eq 0 ]; then
	echo "Usage: $0 nom_dossier"
	exit 1
fi


# Création du dossier
mkdir -p "../client/$1"
mkdir -p "../client/$1/images"

# Attribution des permissions
chmod 777 "../client/$1"
chmod 777 "../client/$1/images"

# Affichage du message de confirmation
echo "Les dossiers ont été créés avec succès."
exit 0