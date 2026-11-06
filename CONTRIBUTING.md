# Contributing to Milarie Accounting

First off, thank you for taking the time to contribute! 🎉 Milarie Accounting is an open-source project, and we thrive on community involvement, bug reports, feature suggestions, and code contributions.

Please review this document to help make your contribution experience smooth and effective.

---

## 🧭 Code of Conduct

By participating in this project, you agree to abide by our terms. Please report unacceptable behavior to our maintainer team. Treat everyone with respect, patience, and professional courtesy.

---

## 🚀 How Can I Contribute?

### 1. Reporting Bugs
Found a bug? Help us squash it by opening an issue on GitHub. Please include:
* A clear and descriptive title.
* Steps to reproduce the issue.
* Expected vs. actual behavior.
* Screenshots or error logs (without sensitive financial data).

### 2. Suggesting New Features
We love innovative ideas to make financial management easier for SMEs! Before creating a feature request:
* Check existing issues and pull requests to avoid duplicates.
* Clearly describe the feature, why it is needed, and how it would benefit users.

### 3. Contributing Code
Ready to write some code? Follow these steps to get started:

#### Step A: Fork & Clone
1. Fork the repository on GitHub.
2. Clone your fork locally:
   ```bash
   git clone https://github.com/your-username/milarie-accounting.git
   cd milarie-accounting
   ```

#### Step B: Set Up Your Development Environment
Make sure you have Node.js, npm/yarn, and PostgreSQL installed. Follow the manual installation guide in the main `README.md` to get your local database and server running.

#### Step C: Create a Branch
Create a descriptive branch name for your fix or feature:
```bash
git checkout -b feature/your-feature-name
# or
git checkout -b fix/issue-number
```

#### Step D: Make Your Changes
* Write clean, maintainable code adhering to the project's coding standards.
* Add or update tests as appropriate for your changes.
* Ensure all tests pass locally before committing.

#### Step E: Commit Your Changes
We follow conventional commit messages:
* `feat: add multi-currency exchange rate updater`
* `fix: resolve balance sheet calculation error on leap years`
* `docs: update API authentication guide` 

#### Step F: Push and Submit a Pull Request (PR)
1. Push your branch to GitHub:
   ```bash
   git push origin feature/your-feature-name
   ```
   
2. Open a Pull Request against the `main` branch of the official `milarie/milarie-accounting` repository.
3. Fill out the PR template explaining your changes and linking any related issues.

---

## 🧪 Running Tests

Before submitting your PR, make sure your code passes the test suite:
```bash
npm test
```

---

## 💬 Community & Support

If you have questions or need guidance while contributing, feel free to open a discussion on GitHub or reach out to the core maintainers.

Thank you for helping us empower SMEs worldwide with open-source financial tools!