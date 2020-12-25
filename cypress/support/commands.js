import 'cypress-file-upload';

Cypress.Commands.add('checkDb', (table, data) => {
    let column = Object.keys(data).toString();
    let value = Object.values(data).toString();

    cy.task('queryDb', 'SELECT * FROM '+ table +' where '+ column +'="'+ value +'"').then((xhr) => {
        cy.wrap(xhr[0]).its(column).should('eq', value);
    })
})

Cypress.Commands.add('checkDbMissing', (table, data) => {
    let column = Object.keys(data).toString();
    let value = Object.values(data).toString();

    cy.task('queryDb', 'SELECT * FROM '+ table +' where '+ column +'="'+ value +'"').then((xhr) => {
        cy.wrap(xhr).should('be.empty');
    })
})

Cypress.Commands.add('truncateDb', (table) => {
    cy.task('queryDb', 'truncate table '+table);
})

Cypress.Commands.add('insertData', (table, data) => {
    let columns = Object.keys(data).toString();
    let values = Object.values(data).toString();
    
    cy.task('queryDb', 'INSERT INTO '+ table +' ('+ columns +') VALUES ('+ values +') ');
})

Cypress.Commands.add('searchData', (table, data) => {
    let column = Object.keys(data).toString();
    let value = Object.values(data).toString();
    
    cy.task('queryDb', 'select * from '+table+ ' where '+ column +' = '+ value);
})


Cypress.Commands.add(
    'attach_file',
    { prevSubject: 'element' },
    (input, fileName, fileType) => {
        cy.fixture(fileName)
            .then(content => {
                const blob = Cypress.Blob.base64StringToBlob(content, fileType);
                const testFile = new File([blob], fileName)
                const dataTransfer = new DataTransfer()

                dataTransfer.items.add(testFile)
                input[0].files = dataTransfer.files
                return input;
            })
        ;
    }
)