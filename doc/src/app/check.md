# Vérifications

Répertoire de toute les vérifications pouvant être effectué pour chaque requete.


<br>


## Méthode

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>

Chaque route détient une liste de  méthodes autorisée. Cette vérification est la première effectuée à chaque requête. 

### - Response - *405*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 405,
    "status_message": "[R405 REST AUTH] : Methodes utilisées non autorisées"
}
```

<br>

</details>


---

## Argument

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>


Utilisé quand la requete attend un argument que ca soit un `{id}` ou un nom de fonction tel que `{usager}` (pour les statistiques).

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST API] : Aucun argument n\'a été fourni"
}
```


<br>

</details>


---

## Type argument string

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>


Utilisé pour vérifier le type d'argument que l'on attend est une `string`.

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST] : L\'argument doit être une chaine de caractère"
}
```


<br>

</details>



---

## Type argument int

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>


Utilisé pour vérifier le type d'argument que l'on attend est un `int` (pour les `{id}`). Impose une taille limite de `2147483647`.

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST] : L\'identifiant doit être un entier positif non null"
}
```

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST] : L\'identifiant doit être un entier inférieur à 2147483647"
}
```


<br>

</details>

---

## Date

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>


Utilisé pour vérifier si une date est inférieure (date de naissance) ou supèrieur (rendez-vous) à la date actuelle.

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST API] : La date <date_parametre> est invalide car elle est inferieure à la date actuelle"
}
```

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST API] : La date <date_parametre> est invalide car elle est supérieure à la date actuelle"
}
```

<br>

</details>

---

## Medecin

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>


Utilisé pour vérifier à partir d'un ID si un medecin existe.

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
    "status_message": "[R404 REST API] : Aucun Medecin avec l'id <id> n'a été trouvé"
}
```


<br>

</details>

---

## Usager

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>


Utilisé pour vérifier à partir d'un ID si un usager existe.

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
    "status_message": "[R404 REST API] : Aucun usager avec l'id <id> n'a été trouvé"
}
```


<br>

</details>

---

## Civilité

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translate(-30px, -55px);">
</summary>

Vérifie si la civilité est valide. Celle ci doit être soit `M.` soit `Mme`.

### - Response - *400*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 400,
    "status_message": "[R400 REST API] : La civilité doit être soit 'M.' soit 'Mme'"
}
```

<br>

</details>

---