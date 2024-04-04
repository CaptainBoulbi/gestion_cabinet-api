# Vérifications

Répertoire de toute les vérifications pouvant être effectué pour chaque requete.

Si une vérification passe avec succès rien n'est renvoyé. On reçoit un message d'erreur dans le cas contraire.


<br>


## Argument

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>


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
    "status_message": "[R400 REST API] : Aucun argument n'a été fourni"
}
```


<br>

</details>


---

## Civilité

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

Vérifie si la civilité est valide. Celle ci doit être soit `M.` soit `Mme.`.

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

## Contrôle d'Accès

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

Certaines données ne peuvent être visualisée, modifiée ou supprimée uniquement par un administrateur, une secretaire ou leur propriétaire.
On vérifie donc en fonction du role actuel de l'utilisateur si il à le droit d'efffectuer l'action demandée.

De ce fait, un médecin ne pourras par exemple que modifier ses rendez-vous ou alors un usager ne pourras pas visualiser les informations des autres usagers. Voir les [tables d'accès](app.html#tables-daccès)

### - Response - *403*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 403,
    "status_message": "[R403 REST API] : Vous n'avez pas le droit de visualiser/modifier/supprimer cet <élement>"
}
```


<br>

</details>


---

## Date

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>


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
    "status_message": "[R400 REST API] : La date <date_parametre> est invalide car elle est inferieure/supérieure à la date actuelle"
}
```

<br>

</details>

---

## Données Autorisées

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

A partir des données passées en corps, vérifie si touts les champs sont autorisés (surtout pour les requêtes de modification).

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
    "status_message": "[R400 REST API] : Le champ <champs> n'est pas autorisé"
}
```

<br>

</details>

---

## Données Nécessaires

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

A partir des données passées en corps, vérifie si touts les champs nécessaires sont présents (surtout pour les requêtes de création).

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
    "status_message": "[R400 REST API] : Le champ <champs> est requis"
}
```

<br>

</details>

---

## Element Existe

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

Utilisé pour vérifier à partir d'un ID si un element existe (en fonction de si la requête est faites pour un médecin, un usager ou une consultations).

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
    "status_message": "[R404 REST API] : Aucun <element> avec l'ID <id> n'a été trouvé"
}
```

<br>

</details>

---

## Jeton

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

Verifie si le jeton est présent dans le header d'autorisation et si ce dernier est valide.
La vérification de la validité est effectuée coté serveur d'authentification et l'erreur de validité est retournée coté serveur application.

### - Response - *401*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 401,
    "status_message": "[401 REST AUTH] : Jeton requis."
}
```

### - Response - *401*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 401,
    "status_message": "[401 REST AUTH] : Jeton invalide."
}
```


<br>

</details>

---

## Méthode

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

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

## Roles

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>


Sachant que toutes les requêtes necessite un token, on vérifie à chacune d'entre elles les roles autorisés à effectuer la requête.

### - Response - *403*

**Header :**

```yaml
Content-Type : application/json
```

**Body :**

```json
{
    "status": "error",
    "status_code": 403,
    "status_message": "[R403 REST AUTH] : Rôle non autorisé à effectuer cette action."
}
```


<br>

</details>

---

## Sécurité sociale

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

Vérifie si le numéro de sécurité sociale est disponible.

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
    "status_message": "[R400 REST API] :  Le numéro de sécurité sociale <numéro> est déjà utilisé"
}
```

<br>

</details>

---

## Sexe

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>

Vérifie si le sexe est valide. Celui-ci doit être soit `H` soit `F`.

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
    "status_message": "[R400 REST API] : Le sexe doit être soit 'H' soit 'F'"
}
```

<br>

</details>

---

## Type argument int

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>


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

## Type argument string

<details open>
<summary style="font-size: 1.5em; font-weight: bold; transform: translateY(23px);">
</summary>
<br>


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
