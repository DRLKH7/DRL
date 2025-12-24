import express from "express";

const router = express.Router();

router.get("/", (req, res) => {
  res.json({
    meta: {
      success: true,
      message: "API is working",
    },
    routes: {
      home: "/api",
      status: "/api/status",
    },
  });
});

router.get("/status", (req, res) => {
  res.json({
    meta: {
      success: true,
      message: "Status endpoint",
    },
    status: {
      uptime: process.uptime(),
      timestamp: Date.now(),
    },
  });
});

export default router;
