describe('template spec', () => {
  it('passes', () => {
    cy.visit('http://localhost:8080/login')

    cy.get('input[name="email"]').type("test@email.com")
    cy.get('input[name="password"]').type("12345678")

    cy.get('#sub-btn').click()
    cy.location("pathname").should('eq', '/home')
    cy.visit('http://localhost:8080/recepies')

    cy.get('#add_rec').click()

    cy.get('input[name="recepie-name"]').type('testRecepie')
    cy.get('input[name="prep-time"]').type('20')
    cy.get('input[name="cook-time"]').type('40')
    cy.get('input[name="calories"]').type('980')
    cy.get('input[name="servings"]').type('4')
    cy.get('textarea[name="instructions"]').type('testing instructions')

    cy.get('#ingred-btn').click()

    cy.get('select[name="ingred-1"]').select(1)
    cy.get('input[name="count-1"]').type('6')
    cy.get('select[name="mes-1"]').select('tbsp')

    cy.get('button[id="sub_rec_btn"]').click()
  })
})