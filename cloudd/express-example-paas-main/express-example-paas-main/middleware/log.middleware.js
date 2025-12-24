const logMiddleware = (req, res, next) => {
  const now = new Date();
  const timestamp = now.toISOString().replace('T', ' ').substring(0, 19);
  console.log(`[${timestamp}] ${req.method} ${req.url}`);
  next();
};

export default logMiddleware;