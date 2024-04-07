# Usagers

Utilisé pour permettre de modifier le contenu en rapport avec les usagers.
Chaque requête possède une [vérification des roles](check.html#roles)

**Méthodes autorisées :** &nbsp;&nbsp;&nbsp; [`GET`, `POST`, `PATCH`, `DELETE`, `OPTIONS`]

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/usagers</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir tout les usagers</div>
</summary>

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/usagers`

**Header :**

```yaml
Authorization : Bearer eyJhbGc...
```

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 200
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 200,
    "status_message": "[R200 REST API] : Usagers trouvés",
    "data": [
        {
            "id_usager": 1,
            "civilite": "M.",
            "nom": "Dupont",
            "prenom": "Jean",
            "sexe": "H",
            "adresse": "1 rue de la Paix",
            "code_postal": "75000",
            "ville": "Paris",
            "date_nais": "1990-01-06",
            "lieu_nais": "Paris",
            "num_secu": "180010101010101",
            "login": "UMODUJE72",
            "id_medecin": 7
        },
        ...
    ]
}
```
</details>
<br>

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 404
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 404,
    "status_message": "[R404 REST API] : Aucun usager trouvé"
}
```
</details>

<br>

</details>

<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/usagers/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir un usager</div>
</summary>

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument int](check.html#type-argument-int)
- [Usager existe](check.html#element-existe)
- [Droit de visualisation](check.html#contrôle-daccès)


### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/usagers/{id}`

**Header :**

```yaml
Authorization : Bearer eyJhbGc...
```

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 200
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 200,
    "status_message": "[R200 REST API] : Usager trouvé",
    "data": {
        "id_usager": 2,
        "civilite": "Mme.",
        "nom": "Durand",
        "prenom": "Marie",
        "sexe": "F",
        "adresse": "2 avenu de l'Angle",
        "code_postal": "31320",
        "ville": "Auzeville-Tolosane",
        "date_nais": "1987-03-07",
        "lieu_nais": "Clermont-Ferrant",
        "num_secu": "280010101010101",
        "login": "UMADUMA90",
        "id_medecin": 5
    }
}
```
</details>
<br>

</details>

<br>

---

<br>


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/usagers</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Créer un usager</div>
</summary>

Envoie une requête au serveur d'authentification pour ajouter l'usager au répertoire de connexion.

### - Vérifications

- [Données necessaires](check.html#données-nécessaires) : [`civilite`, `nom`, `prenom`, `sexe`, `adresse`, `code_postal`, `ville`, `date_nais`, `lieu_nais`, `num_secu`, `mdp`]
- [Date](check.html#date)
- [Numéro de sécurité sociale](check.html#sécurité-sociale)
- [Civilitée](check.html#civilité)
- [Sexe](check.html#sexe)
- [Médecin existe](check.html#element-existe) (si présent)


### - Authentification 

> Nécessite le role de : &nbsp; <mark style="background-color:#FF5733; color:white;">administrateur</mark> ,&nbsp; <mark style="background-color:#757575; color:white;">invite</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark> 

**URL :** &nbsp;&nbsp;
`/usagers`

**Header :**

```yaml
Content-Type : application/json
Authorization : Bearer eyJhbGc...
```

**Body :**

```json
{
    "civilite":"Mme.",
    "nom":"Dumont",
    "prenom":"Armand",
    "sexe":"H",
    "adresse":"85, Square de la Couronne",
    "code_postal":"91120",
    "ville":"Palaiseau",
    "date_nais":"14/05/1952",
    "lieu_nais":"Nantes",
    "num_secu":"112233445566968",
    "mdp":"user1234!"
}
```


<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 201
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 201,
    "status_message": "[R201 REST API] : Usager inséré en base de donnée avec succès",
    "data": {
        "id_usager": 11,
        "civilite": "Mme.",
        "nom": "Dumont",
        "prenom": "Armand",
        "sexe": "H",
        "adresse": "85, Square de la Couronne",
        "code_postal": "91120",
        "ville": "Palaiseau",
        "date_nais": "1970-01-01",
        "lieu_nais": "Nantes",
        "num_secu": "119936645588688",
        "login": "UMADUAR96",
        "id_medecin": null
    }
}
```
</details>
<br>


<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 500
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 500,
    "status_message": "[R500 REST API] : Erreur lors de l'insertion de l'usager en base de donnée"
}
```
</details>
<br>

</details>

<br>

---

<br>


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #ca5cf9;"><span style="color:white">PATCH</span></mark></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/usagers/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal">Modifier partiellement un usager</div>
</summary>

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument int](check.html#type-argument-int)
- [Données autorisées](check.html#données-autorisées) : [`civilite`, `nom`, `prenom`, `sexe`, `adresse`, `code_postal`, `ville`, `date_nais`, `lieu_nais`, `num_secu`, `id_medecin`]
- [Date](check.html#date) (si présent)
- [Numéro de sécurité sociale](check.html#sécurité-sociale) (si présent)
- [Civilitée](check.html#civilité) (si présent)
- [Sexe](check.html#sexe) (si présent)
- [Médecin existe](check.html#element-existe) (si présent)



### - Authentification 

> Nécessite le role de : <mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #ca5cf9;"><span style="color:white">PATCH</span></mark> 

**URL :** &nbsp;&nbsp;
`/usagers/{id}`

**Header :**

```yaml
Content-Type : application/json
Authorization : Bearer eyJhbGc...
```

**Body :**

```json
{
    "adresse":"85, Square de la Couronne",
    "code_postal":"91120",
    "ville":"Palaiseau",
    "id_medecin":"1"
}
```

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 201
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 201,
    "status_message": "[R201 REST API] : Usager mit à jour avec succès"
}
```
</details>
<br>

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 500
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 500,
    "status_message": "[R500 REST API] : Usager non mis à jour"
}
```
</details>
<br>

</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #f96e5c;"><span style="color:white">DELETE</span></mark></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/usagers/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal">Supprimer un usager</div>
</summary>

Envoie une requête au serveur d'authentification pour supprimer l'usager du répertoire de connexion. Supprime les rendez-vous associés.

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument int](check.html#type-argument-int)
- [Usager existe](check.html#element-existe)
- [Droit de suppression](check.html#contrôle-daccès)

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #f96e5c;"><span style="color:white">DELETE</span></mark>

**URL :** &nbsp;&nbsp;
`/usagers/{id}`

**Header :**

```yaml
Authorization : Bearer eyJhbGc...
```

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 200
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 200,
    "status_message": "[R200 REST API] : Usager supprimé avec succès"
}
```
</details>
<br>

<details>
<summary style="font-size: 1.2em; font-weight: bold; transform: translateY(20px);">
Réponse - 500
</summary>
<br>

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 500,
    "status_message": "[R500 REST API] : Usager non supprimées"
}
```
</details>
<br>

</details>



