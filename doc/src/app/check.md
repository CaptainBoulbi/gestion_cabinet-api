# Vérifications

Répertoire de toute les vérifications pouvant être effectué pour chaque requete.

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification argument
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


</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification type argument string
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


</details>


<br>

---

<br>


<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification type argument int
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


</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification de la date
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


</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification medecin
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


</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification usager
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

</details>


<br>

---

<br>

<details>
<summary style="font-size: 1.5em; font-weight: bold;">
Vérification civilité
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

</details>


<br>

---

<br>