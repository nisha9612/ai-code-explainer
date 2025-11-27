#!/usr/bin/env node

import readline from "readline";
import axios from "axios";
import esprima from "esprima";

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

console.log("=== AI Code Explainer CLI (AST Enabled) ===");

rl.question("Language (javascript/python): ", (language) => {
  console.log("Paste your code. Finish with a blank line:\n");

  let codeLines = [];

  rl.on("line", (line) => {
    if (line.trim() === "") {
      rl.close();
      return;
    }
    codeLines.push(line);
  });

  rl.on("close", async () => {
    const code = codeLines.join("\n");

    let ast = null;

    if (language.toLowerCase() === "javascript") {
      try {
        ast = esprima.parseScript(code, { tolerant: true, loc: true });
      } catch (err) {
        console.log("AST parsing failed:", err.message);
      }
    }

    try {
      const resp = await axios.post("http://localhost:9000/explain", {
        code,
        language,
        ast
      });

      console.log("\n=== Explanation ===\n");
      console.log(resp.data.explanation);
    } catch (err) {
      console.error("Error:", err.message);
    }
  });
});
