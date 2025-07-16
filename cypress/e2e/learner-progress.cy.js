// cypress/e2e/learner-progress.cy.js

describe('Learner Progress Dashboard', () => {
  beforeEach(() => {
    cy.visit('127.0.0.1:8000/learner-progress');
  });

  it('displays a list of learners with their enrolled courses and progress', () => {
    cy.get('table').should('exist');
    cy.get('table tbody tr').should('have.length.at.least', 1);
    cy.get('table tbody tr:first').within(() => {
      cy.contains('%'); // Check for progress value
    });
  });

  it('filters learners by selected course', () => {
    cy.get('#courseFilter').should('exist');
    
    // Select a course other than "All Courses"
    cy.get('#courseFilter option').eq(1).then(option => {
      const courseName = option.text().trim();
      cy.get('#courseFilter').select(courseName);
    });

    // Wait for DataTable to reload
    cy.wait(500);

    // Check that filtered results are shown
    cy.get('table tbody tr').should('have.length.at.least', 1);
  });

  it('sorts learners by average progress when clicking header', () => {
    cy.get('th').contains('Average Progress').click();
    cy.wait(500);

    cy.get('table tbody tr:first').within(() => {
      cy.contains('%');
    });

    // Optionally click again to test reverse sort
    cy.get('th').contains('Average Progress').click();
    cy.wait(500);
  });
});
