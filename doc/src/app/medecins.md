# Medecins


Utilisé pour permettre de modifier le contenu en rapport avec les médecins.


<details open>
<summary style="font-size: 1.5em; font-weight: bold;">
Obtenir tout les médecins
</summary>

### Request
 
<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 
&nbsp; [https://api_med_app.fruitpassion.fr/**medecins**/](https://api_med_app.fruitpassion.fr/medecins/)


### Response - *200*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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

### Response - *404*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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
<summary style="font-size: 1.5em; font-weight: bold;">
Obtenir un médecin avec son id
</summary>

### Request

<mark style="background-color: #65d863;"><span style="color:white">GET</span></mark> 
&nbsp; [https://api_med_app.fruitpassion.fr/**medecins**/*<span style="color:#d147ff">\<id\></span>*](https://api_med_app.fruitpassion.fr/medecins/id)


### Response - *200*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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

### Response - *404*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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
<summary style="font-size: 1.5em; font-weight: bold;">
Créer un médecin
</summary>


> 🛑 <span style="color:red">Important</span>
>
> Nécessite le role de : &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , <mark style="background-color:#FF5733; color:white;">administrateur</mark>

### Request

<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark> 
&nbsp; [https://api_med_app.fruitpassion.fr/**medecins**/](https://api_med_app.fruitpassion.fr/medecins/)


### Response - *201*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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


### Response - *500*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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
<summary style="font-size: 1.5em; font-weight: bold;">
Modifier un médecin avec son id
</summary>

> 🛑 <span style="color:red">Important</span>
>
> Nécessite le role de : &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , <mark style="background-color:#FF5733; color:white;">administrateur</mark> , &nbsp;<mark style="background-color:#27AE60; color:white;">médecin</mark>

### Request

<mark style="background-color: #ca5cf9;"><span style="color:white">PATCH</span></mark> 
&nbsp; [https://api_med_app.fruitpassion.fr/**medecins**/*<span style="color:#d147ff">\<id\></span>*](https://api_med_app.fruitpassion.fr/medecins/id)


### Response - *200*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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

### Response - *404*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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
<summary style="font-size: 1.5em; font-weight: bold;">
Supprimer un médecin avec son id
</summary>


> 🛑 <span style="color:red">Important</span>
>
> Nécessite le role de : &nbsp;<mark style="background-color:#3498DB; color:white;">secrétaire</mark> , <mark style="background-color:#FF5733; color:white;">administrateur</mark>

### Request

<mark style="background-color: #f96e5c;"><span style="color:white">DELETE</span></mark>
&nbsp; [https://api_med_app.fruitpassion.fr/**medecins**/*<span style="color:#d147ff">\<id\></span>*](https://api_med_app.fruitpassion.fr/medecins/id)


### Response - *200*

**Header**

```yaml
Content-Type : application/json
```

**Body**

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

### Response - *404*

**Header**

```yaml
Content-Type : application/json
```

**Body**

```json
{
    "status": "error",
    "status_code": 404,
    "status_message": "[R404 REST API] : Aucun médecin trouvé"
}
```

</details>



