#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}      Download CDN Assets to Local (Offline Mode)          ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

# Create directories
echo -e "\n${YELLOW}[1/8] Creating asset directories...${NC}"
mkdir -p public/assets/{bootstrap,datatables,jquery,chartjs,fontawesome}
mkdir -p public/assets/fontawesome/webfonts

echo -e "${GREEN}✓ Directories created${NC}"

# Download Bootstrap 5
echo -e "\n${YELLOW}[2/8] Downloading Bootstrap 5...${NC}"
curl -L https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css -o public/assets/bootstrap/bootstrap.min.css
curl -L https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js -o public/assets/bootstrap/bootstrap.bundle.min.js
echo -e "${GREEN}✓ Bootstrap downloaded${NC}"

# Download jQuery
echo -e "\n${YELLOW}[3/8] Downloading jQuery...${NC}"
curl -L https://code.jquery.com/jquery-3.7.0.min.js -o public/assets/jquery/jquery-3.7.0.min.js
echo -e "${GREEN}✓ jQuery downloaded${NC}"

# Download DataTables
echo -e "\n${YELLOW}[4/8] Downloading DataTables...${NC}"
curl -L https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css -o public/assets/datatables/dataTables.bootstrap5.min.css
curl -L https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js -o public/assets/datatables/jquery.dataTables.min.js
curl -L https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js -o public/assets/datatables/dataTables.bootstrap5.min.js
echo -e "${GREEN}✓ DataTables downloaded${NC}"

# Download Chart.js
echo -e "\n${YELLOW}[5/8] Downloading Chart.js...${NC}"
curl -L https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js -o public/assets/chartjs/chart.min.js
echo -e "${GREEN}✓ Chart.js downloaded${NC}"

# Download Font Awesome
echo -e "\n${YELLOW}[6/8] Downloading Font Awesome...${NC}"
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css -o public/assets/fontawesome/all.min.css

# Download Font Awesome webfonts
echo "Downloading Font Awesome webfonts..."
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/webfonts/fa-solid-900.woff2 -o public/assets/fontawesome/webfonts/fa-solid-900.woff2
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/webfonts/fa-solid-900.ttf -o public/assets/fontawesome/webfonts/fa-solid-900.ttf
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/webfonts/fa-regular-400.woff2 -o public/assets/fontawesome/webfonts/fa-regular-400.woff2
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/webfonts/fa-regular-400.ttf -o public/assets/fontawesome/webfonts/fa-regular-400.ttf
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/webfonts/fa-brands-400.woff2 -o public/assets/fontawesome/webfonts/fa-brands-400.woff2
curl -L https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/webfonts/fa-brands-400.ttf -o public/assets/fontawesome/webfonts/fa-brands-400.ttf

# Fix Font Awesome CSS path
sed -i 's|../webfonts/|webfonts/|g' public/assets/fontawesome/all.min.css

echo -e "${GREEN}✓ Font Awesome downloaded${NC}"

# Download additional common libraries
echo -e "\n${YELLOW}[7/8] Downloading additional libraries...${NC}"

# jQuery Validation
curl -L https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js -o public/assets/jquery/jquery.validate.min.js

# Moment.js (untuk date handling)
curl -L https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js -o public/assets/jquery/moment.min.js

# SweetAlert2 (untuk alerts)
mkdir -p public/assets/sweetalert2
curl -L https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css -o public/assets/sweetalert2/sweetalert2.min.css
curl -L https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.js -o public/assets/sweetalert2/sweetalert2.min.js

echo -e "${GREEN}✓ Additional libraries downloaded${NC}"

# Set permissions
echo -e "\n${YELLOW}[8/8] Setting permissions...${NC}"
chmod -R 755 public/assets/
docker-compose exec -T php chown -R www-data:www-data public/assets/ 2>/dev/null || true

echo -e "${GREEN}✓ Permissions set${NC}"

# Show summary
echo -e "\n${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}            Download Complete!                              ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

echo -e "\n${BLUE}Assets Location:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
du -sh public/assets/* 2>/dev/null | sort -h

echo -e "\n${BLUE}Total Size:${NC}"
du -sh public/assets/ 2>/dev/null

echo -e "\n${YELLOW}Next Steps:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "1. Update your Blade templates to use local assets"
echo "2. Run: ./update-blade-cdn.sh (will be created next)"
echo "3. Test in browser without internet"
echo ""
echo -e "${GREEN}Assets are now available at:${NC}"
echo "  /assets/bootstrap/bootstrap.min.css"
echo "  /assets/bootstrap/bootstrap.bundle.min.js"
echo "  /assets/jquery/jquery-3.7.0.min.js"
echo "  /assets/datatables/dataTables.bootstrap5.min.css"
echo "  /assets/datatables/jquery.dataTables.min.js"
echo "  /assets/fontawesome/all.min.css"
echo "  /assets/chartjs/chart.min.js"
