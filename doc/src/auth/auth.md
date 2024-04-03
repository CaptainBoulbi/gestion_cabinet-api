# API Authentification

Lien de l'api :
- [api_med_auth.fruitpassion.fr](api_med_auth.fruitpassion.fr)


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
