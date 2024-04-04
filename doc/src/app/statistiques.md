# Statistiques

Utilisé pour permettre de visuliser les différentes statistiques de l'application.
Chaque requête possède une [vérification des roles](check.html#roles)

**Méthodes autorisées :** &nbsp;&nbsp;&nbsp; [`GET`, `OPTIONS`]


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/stats/medecins</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir les stats de chaque médecin</div>
</summary>

Pour chaque médecin, spécifie le nombre d'heure de consultation totales effectuées.

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument string](check.html#type-argument-string)

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark> , &nbsp;<mark style="background-color:#757575; color:white;">invite</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/stats/medecins`

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
    "status_message": "[R200 REST API] : Statistiques des médecins récupérées",
    "data": [
        {
            "id_medecin": 1,
            "civilite": "M.",
            "nom": "Dupont",
            "prenom": "Xavier",
            "heures_consultees": "1h15"
        },
        {
            "id_medecin": 2,
            "civilite": "Mme.",
            "nom": "Darc",
            "prenom": "Jeanne",
            "heures_consultees": "2h30"
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
    "status_message": "[R404 REST API] : Aucun médecin trouvé"
}
```
</details>

<br>

</details>

<br>

---


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/stats/usagers</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir les stats des usagers</div>
</summary>

Permet de savoir en le nombre d'homme et de femme de différentes tranches d'âge.

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument string](check.html#type-argument-string)

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark> , &nbsp;<mark style="background-color:#757575; color:white;">invite</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/stats/usagers`

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
    "status_message": "[R200 REST API] : Statistiques des usagers récupérées",
    "data": {
        "moins25": {
            "homme": 2,
            "femme": 1
        },
        "entre25et50": {
            "homme": 3,
            "femme": 2
        },
        "plus50": {
            "homme": 0,
            "femme": 2
        }
    }
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

## Pour tout autre méthode :

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
    "status_message": "[R404 REST API] : Aucune statistique ne correspond à cette requete"
}
```
</details>