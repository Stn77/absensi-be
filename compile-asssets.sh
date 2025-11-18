docker compose up vite node -d
docker compose exec node npm run build
docker compose down vite node 
