describe('Signup user', () => {
  it('passes', () => {
    cy.visit('http://localhost:8080/register')

    cy.get('input[name="company_name"]').type("testcompay")
    cy.get('input[name="first_name"]').type("John")
    cy.get('input[name="last_name"]').type("Doe")
    cy.get('input[name="email"]').type("test@email.com")
    cy.get('input[name="address"]').type("testingstreet")
    cy.get('input[name="city"]').type("valmiera")
    cy.get('input[name="district"]').type("valmiera")
    cy.get('input[name="country"]').type("Latvia")
    cy.get('input[name="post_code"]').type("LV-4201")
    cy.get('input[name="password"]').type("12345678")
    cy.get('input[name="password_confirmation"]').type("12345678")

    cy.get('#sub-btn').click()
    cy.location("pathname").should('eq', '/home')
  })
})