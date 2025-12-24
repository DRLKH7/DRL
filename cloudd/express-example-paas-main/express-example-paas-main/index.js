import express from "express";
import path from "path";
import errorMiddleware from "./middleware/error.middleware.js";
import logMiddleware from "./middleware/log.middleware.js";
import apiRouter from "./routes/api.js";
import webRouter from "./routes/web.js";

const app = express();
const PORT = process.env.PORT || 3000;

const __dirname = path.resolve();

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "public")));

app.set("view engine", "pug");
app.set("views", path.join(__dirname, "views"));
app.set("port", PORT);

app.use(logMiddleware);

app.use("/api", apiRouter);
app.use("/", webRouter);

app.use(errorMiddleware);

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
