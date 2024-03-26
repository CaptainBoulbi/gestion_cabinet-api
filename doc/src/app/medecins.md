# Medecins


Utilisé pour permettre de modifier le contenu en rapport avec les médecins.

**Allowed Methods :** &nbsp;&nbsp;&nbsp; [`GET`, `POST`, `PATCH`, `DELETE`, `OPTIONS`]

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/medecins/</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir tout les médecins </div>

</summary>

### - Authentication 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/medecins/`

**Header :**

```yaml
Authorization : Bearer eyJhbGc...
```


### - Response - *200*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 200,
    "status_message": "[R200 REST API] : Médecins trouvés",
    "data": [
        {
            "id_medecin": 1,
            "civilite": "M.",
            "nom": "Dupont",
            "prenom": "Xavier"
        },
        {
            "id_medecin": 2,
            "civilite": "Mme.",
            "nom": "Darc",
            "prenom": "Jeanne"
        },
        ...
    ]
}
```

### - Response - *404*

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

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/medecins/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Obtenir un médecin</div>

</summary>

### - Authentication 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">mecedin</mark> , &nbsp;<mark style="background-color:#F1C40F; color:white;">usager</mark>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 

**URL :** &nbsp;&nbsp;
`/medecins/{id}`

**Header :**

```yaml
Authorization : Bearer eyJhbGc...
```

### - Response - *200*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 200,
    "status_message": "[R200 REST API] : Médecin trouvé",
    "data": [
        {
            "id_medecin": 1,
            "civilite": "M.",
            "nom": "Dupont",
            "prenom": "Xavier"
        }
    ]
}
```

### - Response - *404*

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

---

<br>


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/medecins/</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal"> Créer un médecin</div>
</summary>


### - Authentication 

> Nécessite le role de : &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , <mark style="background-color:#FF5733; color:white;">administrateur</mark>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark> 

**URL :** &nbsp;&nbsp;
`/medecins/`

**Header :**

```yaml
Content-Type : application/json
Authorization : Bearer eyJhbGc...
```

**Body :**

```json
{
    "civilite":"M.",
    "nom":"Dupond",
    "prenom":"Gérard"
}
```


### - Response - *201*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 201,
    "status_message": "[R201 REST API] : Médecin inséré en base de donnée avec succès",
    "data": {
        "id_medecin": 11,
        "civilite": "M.",
        "nom": "Dupond",
        "prenom": "Gérard"
    }
}
```


### - Response - *500*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 500,
    "status_message": "[R500 REST API] : Erreur lors de l'insertion du médecin en base de donnée"
}
```

</details>

<br>

---

<br>


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #ca5cf9;"><span style="color:white">PATCH</span></mark></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/medecins/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal">Modifier partiellement un médecin</div>
</summary>

### - Authentication 

> Nécessite le role de : <mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">médecin</mark>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #ca5cf9;"><span style="color:white">PATCH</span></mark> 

**URL :** &nbsp;&nbsp;
`/medecins/{id}`

**Header :**

```yaml
Content-Type : application/json
Authorization : Bearer eyJhbGc...
```

**Body :**

```json
{
    "civilite":"M.",
    "nom":"Dupond",
    "prenom":"Gérard"
}
```

### - Response - *201*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 201,
    "status_message": "[R201 REST API] : Médecin mit à jour avec succès"
}
```

### - Response - *500*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 500,
    "status_message": "[R500 REST API] : Médecin non mis à jour"
}
```

</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(20px);">
<mark style="background-color: #f96e5c;"><span style="color:white">DELETE</span></mark></mark>&nbsp;<mark style="background-color: #333333;">
<span style="color:white">/medecins/{id}</span></mark><div style="text-align: right; transform: translateY(-38px); font-style: italic; font-weight: normal">Supprimer un médecin</div>
</summary>

### - Authentication 

> Nécessite le role de : &nbsp;<mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">médecin</mark>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #f96e5c;"><span style="color:white">DELETE</span></mark>

**URL :** &nbsp;&nbsp;
`/medecins/{id}`

**Header :**

```yaml
Authorization : Bearer eyJhbGc...
```

### - Response - *200*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "success",
    "status_code": 200,
    "status_message": "[R200 REST API] : Médecin supprimé avec succès"
}
```

### - Response - *500*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 500,
    "status_message": "[R500 REST API] : Médecins non supprimées"
}
```

</details>



