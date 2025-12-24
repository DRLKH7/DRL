const errorMiddleware = (err, req, res, next) => {
  console.error(err.stack);
  if (req.path.startsWith("/api")) {
    res.status(404).json({
      meta: {
        success: false,
        message: "API endpoint not found",
      },
    });
  } else {
    res.status(404).render("404", {
      title: "404 Not Found",
      message: "The page you are looking for does not exist.",
    });
  }
};

export default errorMiddleware;