# Project_S4_Restaurant

Common repository for the ESAIP 4th semester project

# Resources

- JS fetch API : https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch

# DUMP

Get the row ID of the last insert statement :
```sql
INSERT INTO `commande` (ID_bon, ID_etat_commande, ID_lieu_preparation) VALUES
(1, 1, 1);
SELECT LAST_INSERT_ID() id;
```
