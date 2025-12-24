import express from "express";

const router = express.Router();

router.get("/", (req, res) => {
  res.render("index", {
    title: "Home Page",
    message: "Welcome to the Home Page!",
    files: ["Learn Express.js", "Build Web Applications", "Deploy to PaaS"],
  });
});

export default router;
