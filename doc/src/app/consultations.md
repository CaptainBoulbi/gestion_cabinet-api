# Consultations


Utilisé pour permettre de modifier le contenu en rapport avec les consultations.
Chaque requête possède une [vérification des roles](check.html#roles)

**Méthodes autorisées :** &nbsp;&nbsp;&nbsp; [`GET`, `POST`, `PATCH`, `DELETE`, `OPTIONS`]

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/consultations</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir toutes les consultations</div>
</summary>

Pour un médecin ou un usager, supprime les consultation dont ils ne font pas partie

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/consultations`

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
    "status_message": "[R200 REST API] : Consultations trouvées",
    "data": [
        {
            "id_consult": 1,
            "date_consult": "2024-01-01",
            "heure_consult": "08:00:00",
            "duree_consult": 15,
            "id_medecin": 1,
            "id_usager": 1
        },
        {
            "id_consult": 2,
            "date_consult": "2024-01-02",
            "heure_consult": "09:00:00",
            "duree_consult": 30,
            "id_medecin": 2,
            "id_usager": 2
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
    "status_message": "[R404 REST API] : Aucune consultation trouvée"
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
<span style="color:white">/consultations/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir une consultation</div>
</summary>

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument int](check.html#type-argument-int)
- [Consultation existe](check.html#element-existe)
- [Droit de visualisation](check.html#contrôle-daccès)


### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/consultations/{id}`

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
    "status_message": "[R200 REST API] : Consultation trouvée",
    "data": {
        "id_consult": 5,
        "date_consult": "2024-01-05",
        "heure_consult": "12:00:00",
        "duree_consult": 15,
        "id_medecin": 5,
        "id_usager": 5
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
<span style="color:white">/consultations</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Créer une consultation</div>
</summary>

### - Vérifications

- [Droit d'ajout](check.html#contrôle-daccès)
- [Données nécessaires](check.html#données-autorisées) : [`id_medecin`, `id_usager`, `date_consult`, `heure_consult`, `duree_consult`]
- [Médecin existe](check.html#element-existe)
- [Usager existe](check.html#element-existe)
- [Date](check.html#date)
- [Consultation valide](check.html#consultation)
- [Disponibilité usager/médecin](check.html#disponible)


### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>
### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark> 

**URL :** &nbsp;&nbsp;
`/consultations`

**Header :**

```yaml
Content-Type : application/json
Authorization : Bearer eyJhbGc...
```

**Body :**

```json
{
    "id_usager":"7",
    "id_medecin":"8",
    "date_consult":"12/10/2024",
    "heure_consult":"11:30",
    "duree_consult":"30"
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
    "status_message": "[R201 REST API] : Consultation ajoutée",
    "data": {
        "id_consult": 53,
        "date_consult": "2024-12-10",
        "heure_consult": "11:30:00",
        "duree_consult": 30,
        "id_medecin": 8,
        "id_usager": 7
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
    "status_message": "[R500 REST API] : Echec de l'ajout de la consultation"
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
<span style="color:white">/consultations/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal">Modifier une consultation</div>
</summary>

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument int](check.html#type-argument-int)
- [Droit de modification](check.html#contrôle-daccès)
- [Consultation existe](check.html#element-existe)
- [Données autorisées](check.html#données-autorisées) : [`id_medecin`, `id_usager`, `date_consult`, `heure_consult`, `duree_consult`]
- [Date](check.html#date) (si présent)
- [Médecin existe](check.html#element-existe) (si présent)
- [Usager existe](check.html#element-existe) (si présent)
- [Consultation valide](check.html#consultation) (si présent)
- [Disponibilité usager/médecin](check.html#disponible) (si présent)



### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #ca5cf9;"><span style="color:white">PATCH</span></mark> 

**URL :** &nbsp;&nbsp;
`/consultations/{id}`

**Header :**

```yaml
Content-Type : application/json
Authorization : Bearer eyJhbGc...
```

**Body :**

```json
{
    "id_usager":"2",
    "id_medecin":"8",
    "date_consult":"12/10/2024",
    "heure_consult":"12:30",
    "duree_consult":"45"
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
    "status_message": "[R201 REST API] : Consultation modifiée",
    "data": {
        "id_consult": 6,
        "date_consult": "2024-12-10",
        "heure_consult": "12:30:00",
        "duree_consult": 45,
        "id_medecin": 8,
        "id_usager": 2
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
    "status_message": "[R500 REST API] : Echec de la modification de la consultation"
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
<span style="color:white">/consultations/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal">Supprimer une consultation</div>
</summary>

### - Vérifications

- [Argument nécessaire](check.html#argument)
- [Type d'argument int](check.html#type-argument-int)
- [Consultation existe](check.html#element-existe)
- [Droit de suppression](check.html#contrôle-daccès)

### - Authentification 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Requête

**Méthode :** &nbsp;&nbsp;
<mark style="background-color: #f96e5c;"><span style="color:white">DELETE</span></mark>

**URL :** &nbsp;&nbsp;
`/consultations/{id}`

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
    "status_message": "[R200 REST API] : Consultation supprimée avec succès"
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
    "status_message": "[R500 REST API] : Echec de la suppression de la consultatio"
}
```
</details>
<br>

</details>



