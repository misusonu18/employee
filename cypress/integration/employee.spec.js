/// <reference types="cypress" />

context('Employee CRUD Testing', () => {
	beforeEach(() => {
		cy.truncateDb('employee');
	})

	it('Add An Employee', () => {
		cy.visit('/add_employee.php')
			.get('[data-cy=first-name]').type('Abc')
			.get('[data-cy=last-name]').type('Xyz')
			.get('[data-cy=email]').type('abc@gmail.com')
			.get('[data-cy=address]').type('Opp. Ayodhya Chowkdi')
			.get('[data-cy=photo]').attach_file('100.png', 'image/png').trigger('change', { force: true })
			.get('[data-cy=submit]').click()

			.get('body').contains('Employee Inserted Successfully')

			.checkDb('employee', {first_name: 'Abc'})
		;
	})

	it('Edit An Employee', () => {
		cy.insertData('employee', {first_name : '"Vishal"', last_name : '"Parmar"', email : '"mishal@gmail.com"', address : '"near Ayodhya Chowkdi"'});

		cy.searchData('employee', {first_name: '"Vishal"'}).then((xhr) => {
			let employee = xhr[0];

			cy.visit('/')
				.get('[data-cy=edit-'+ employee.id +']').click()
				.get('[data-cy=first-name]').clear().type('Abc')
				.get('[data-cy=address]').clear().type('Opp. xya Near Abc')
				.get('[data-cy=photo]').attach_file('100.png', 'image/png').trigger('change', { force: true })
				.get('[data-cy=update]').click()

				.get('body').contains("Employee Updated Successfully")

				.checkDb('employee', {first_name: 'Abc'})
			;
		})
	})

	it.only('Delete An Employee', () => {
		cy.insertData('employee', {first_name : '"Mishal"', last_name : '"Parmar"', email : '"mishal@gmail.com"', address : '"near Ayodhya Chowkdi"'});

		cy.searchData('employee', {first_name: '"Mishal"'}).then((xhr) => {
			let employee = xhr[0];

			cy.visit('/')
				.get('[data-cy=delete-'+ employee.id +']').click()
				.get('body').contains('OK').click()

				.get('body').contains("Employee Deleted Successfully")

				.checkDbMissing('employee', {id: employee.id})
			;
		});
	})
})
  