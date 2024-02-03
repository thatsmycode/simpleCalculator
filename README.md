# simpleCalculator
This part of a technical test for a junior position.

# Deployed project link
https://simplecalculator.adaptable.app/

## Objectives:
Create an application using PHP.

The app is a small calculator that accepts 4 inputs:

1. username   (mandatory)
2. operand_1  (mandatory)
3. operand_2  (mandatory)
4. operand_3  (optional)

The content of these fields must be numerical or alphanumerical.

If all 3 operators are numerical the it needs to sum them,
if not a concatenation will be the operation to do.

The application must show the result of the operation or a message if any of the mandatory fields are not filled.

Each operation needs to be stored in memory, saving the name of the user who submits it.

If an operation has been submited already, the result but also the name of the previous user who submited it will be displayed.

## Error handling:

The application provides error hadling for the following scenarios:

- Missing mandatory fields
- Invalid inputs
- Ensures that the request is made via the website form and not externally

## Security

As the application uses sessions to store in memory the operations the following mesures have been implemented:

- Ensure PHP sessions are only maintained using cookies
- Enable strict mode to help prevent session fixation attacks
- One hour of session lifetime 
- Specify the domain where the application is deployed to prevent cookies being send to other domains
- Ensure that the session cookie is sent over secure connection
- Restrict the session cookie from being accessed via client-side scripts