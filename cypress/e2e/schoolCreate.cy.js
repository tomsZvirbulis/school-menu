describe('template spec', () => {
  it('passes', () => {
    cy.visit('http://localhost:8080/login')

    cy.get('input[name="email"]').type("test@email.com")
    cy.get('input[name="password"]').type("12345678")

    cy.get('#sub-btn').click()
    cy.location("pathname").should('eq', '/home')

    cy.visit('http://localhost:8080/user')

    cy.get('input[name="school_name"]').type("testschool")
    cy.get('input[id="form6Example1 school_first_name"]').type("Jane")
    cy.get('input[id="form6Example2 school_surname"]').type("Doe")
    cy.get('input[id="form6Example5 school_email"]').type("testschool@email.com")
    cy.get('input[name="address"]').type("testingstreet")
    cy.get('input[name="city"]').type("valmiera")
    cy.get('input[name="district"]').type("valmiera")
    cy.get('input[name="country"]').type("Latvia")
    cy.get('input[name="post_code"]').type("LV-4201")
    cy.get('input[id="form6Example1 school_password"]').type("12345678")
    cy.get('input[id="form6Example2 school_password_confirmation"]').type("12345678")

    cy.get('#school_sub').click()

  })
})