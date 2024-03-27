# API Authentification

Lien de l'api :
- [api_med_auth.fruitpassion.fr](api_med_auth.fruitpassion.fr)

Pour n'importe quelle action l'api requiert un JWT. Une authentification sans compte peux se faire via le role &nbsp; <mark style="background-color:#757575; color:white;">invite</mark>.

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Se connecter en tant que <mark style="background-color:#757575; color:white;">invite</mark>
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

</details>

<br>

>  ℹ️ Note
>  
>  Le symbole `🚹` signifie qu'une action n'est possible que sur son propre compte.
>
> Par exemple un medecin ayant `✅ 🚹` à l'action `Modifier`, ne peux que modifier que des informations de son propre compte.

## Interaction avec les médecins 

 Role  | Visualiser | Créer | Modifier | Supprimer 
:------:|:-----:|:-----:|:-----:|:-----:
<mark style="background-color:#FF5733; color:white;">administrateur</mark> &nbsp; | ✅ | ✅ | ✅ | ✅
<mark style="background-color:#3498DB; color:white;">secretaire</mark> &nbsp; | ✅ | ✅ | ❌ | ❌
<mark style="background-color:#27AE60; color:white;">medecin</mark> &nbsp; | ✅ | ❌ | ✅ 🚹 | ✅ 🚹
<mark style="background-color:#F1C40F; color:white;">usager</mark> &nbsp; | ✅ | ❌ | ❌ | ❌
<mark style="background-color:#757575; color:white;">invite</mark> &nbsp; | ✅ | ❌ | ❌ | ❌


## Interaction avec les usagers 

 Role  | Visualiser | Créer | Modifier | Supprimer 
:------:|:-----:|:-----:|:-----:|:-----:
<mark style="background-color:#FF5733; color:white;">administrateur</mark> &nbsp; | ✅ | ✅ | ✅ | ✅
<mark style="background-color:#3498DB; color:white;">secretaire</mark> &nbsp; | ✅ | ❌ | ❌ | ❌
<mark style="background-color:#27AE60; color:white;">medecin</mark> &nbsp; | ✅ | ❌ | ❌ | ❌
<mark style="background-color:#F1C40F; color:white;">usager</mark> &nbsp; | ✅ 🚹 | ❌ | ✅ 🚹 | ✅ 🚹
<mark style="background-color:#757575; color:white;">invite</mark> &nbsp; | ❌ | ✅ | ❌ | ❌

> *A noter qu'un usager ne peux être créer que via un compte invité. Une fois que l'invité à créer son compte usager, il bascule automatiquement vers celui-ci.*

## Interaction avec les consultations 

 Role  | Visualiser | Créer | Modifier | Supprimer 
:------:|:-----:|:-----:|:-----:|:-----:
<mark style="background-color:#FF5733; color:white;">administrateur</mark> &nbsp; | ✅ | ✅ | ✅ | ✅
<mark style="background-color:#3498DB; color:white;">secretaire</mark> &nbsp; | ✅ | ✅ | ✅ | ✅
<mark style="background-color:#27AE60; color:white;">medecin</mark> &nbsp; | ✅ 🚹 | ✅ 🚹 | ✅ 🚹 | ✅ 🚹
<mark style="background-color:#F1C40F; color:white;">usager</mark> &nbsp; | ✅ 🚹 | ✅ 🚹 | ✅ 🚹 | ✅ 🚹
<mark style="background-color:#757575; color:white;">invite</mark> &nbsp; | ❌ | ❌ | ❌ | ❌


## Interaction avec les statistiques 

 Role  | Visualiser 
:------:|:-----:
<mark style="background-color:#FF5733; color:white;">administrateur</mark> &nbsp; | ✅ 
<mark style="background-color:#3498DB; color:white;">secretaire</mark> &nbsp; | ✅
<mark style="background-color:#27AE60; color:white;">medecin</mark> &nbsp; | ✅ 
<mark style="background-color:#F1C40F; color:white;">usager</mark> &nbsp; | ✅
<mark style="background-color:#757575; color:white;">invite</mark> &nbsp; | ✅