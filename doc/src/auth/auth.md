# API Authentification

Lien de l'api :
- [https://api-med-auth.fruitpassion.fr](https://api-med-auth.fruitpassion.fr)


## Se connecter en tant que <mark style="background-color:#757575; color:white;">invite</mark>

<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark> 

**URL :** &nbsp;&nbsp;
`/`

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "login":"invite"
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
    "status_message": "[R201 REST AUTH] : Authentification OK",
    "data": [
        "eyJhb..."
    ]
}
```

<br>

</details>

<hr>

## Se connecter en tant que <mark style="background-color:#F1C40F; color:white;">usager</mark>


<details>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>

### - Request

**Method :** &nbsp;&nbsp;
<mark style="background-color: #eade59;"><span style="color:white">POST</span></mark> 

**URL :** &nbsp;&nbsp;
`/`

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "login":"usager",
    "mdp":"mdp"
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
    "status_message": "[R201 REST AUTH] : Authentification OK",
    "data": [
        "eyJhb..."
    ]
}
```

<br>

</details>

<hr>

### Mots de passe de connexion

 Role  | Mot de passe 
:------:|:-----:
<mark style="background-color:#FF5733; color:white;">administrateur</mark> &nbsp; | `password1234!`
<mark style="background-color:#3498DB; color:white;">secretaire</mark> &nbsp; | `password1234!`
<mark style="background-color:#27AE60; color:white;">medecin</mark> &nbsp; | `med1234!`
<mark style="background-color:#F1C40F; color:white;">usager</mark> &nbsp; | `user1234!` 

> *Le mot de passe médecin et usaager concerne les 10 premieres entitées de chaque qui sont prégénérées.*