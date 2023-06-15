describe('template spec', () => {
  it('passes', () => {
    cy.visit('http://localhost:8080/login')

    cy.get('input[name="email"]').type("test@email.com")
    cy.get('input[name="password"]').type("12345678")

    cy.get('#sub-btn').click()
    cy.location("pathname").should('eq', '/home')
  })
})