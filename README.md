# ⚡ AI Code Explainer (PHP + Node.js + AST Parsing)

An AI-powered code analysis tool that explains source code using Abstract Syntax Tree (AST) parsing and modern Large Language Models (LLMs).  
Supports **JavaScript**, **Python** (optional), and integrates with OpenAI, Groq (free), or Mistral.

This project is designed for technical evaluation, demonstrating practical software engineering skills including AST parsing, API design, prompt engineering, modular services, and cross-platform CLI tooling.

---

## Features

### Core Features
- Explain code in natural language  
- AST-powered analysis for higher accuracy  
- CLI-based interactive tool  
- Lightweight PHP backend (no frameworks)  
- Clean service architecture  

### Enhanced / Bonus Features
- Multi-provider AI support (OpenAI, Groq, Mistral)  
- AST-driven prompt optimization  
- Ready for Diff View comparisons (bonus requirement)  
- Extensible design for UI-based version  

---
## Folder Structure

ai-code-explainer/
│
├── app/
│ ├── Controllers/
│ │ └── ExplainController.php
│ ├── Services/
│ │ ├── OpenAIService.php
│ │ └── MistralService.php
│
├── cli/
│ ├── cli.js
│ └── package.json
│
├── docs/
│ └── summary.md
│
├── public/
│ └── index.php
│
├── .env
├── composer.json
└── README.md


## Installation & Setup

### 1️.Install PHP dependencies

composer install

cd cli
npm install

OPENAI_API_KEY=your_key_here
MODEL=gpt-4o-mini


Start the backend server
php -S localhost:9000 -t public

Run the CLI
cd cli
node cli.js
