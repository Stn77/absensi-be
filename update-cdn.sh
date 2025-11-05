#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}      Replace CDN Links with Local Assets                  ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

# Backup blade files
echo -e "\n${YELLOW}[1/3] Creating backup of blade files...${NC}"
BACKUP_DIR="blade-backup-$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"
find resources/views -name "*.blade.php" -exec cp --parents {} "$BACKUP_DIR/" \;
echo -e "${GREEN}✓ Backup created in: $BACKUP_DIR${NC}"

# Find all blade files
BLADE_FILES=$(find resources/views -name "*.blade.php")
FILE_COUNT=$(echo "$BLADE_FILES" | wc -l)

echo -e "\n${YELLOW}[2/3] Found $FILE_COUNT blade files to update${NC}"

# Counter
UPDATED=0

for file in $BLADE_FILES; do
    CHANGED=0

    # Bootstrap CSS
    if grep -q "cdn.jsdelivr.net/npm/bootstrap.*\.css" "$file"; then
        sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@[^/]*/dist/css/bootstrap.min.css|{{ asset('\''assets/bootstrap/bootstrap.min.css'\'') }}|g' "$file"
        sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@[^/]*/dist/css/bootstrap.css|{{ asset('\''assets/bootstrap/bootstrap.min.css'\'') }}|g' "$file"
        CHANGED=1
    fi

    # Bootstrap JS
    if grep -q "cdn.jsdelivr.net/npm/bootstrap.*\.js" "$file"; then
        sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@[^/]*/dist/js/bootstrap.bundle.min.js|{{ asset('\''assets/bootstrap/bootstrap.bundle.min.js'\'') }}|g' "$file"
        sed -i 's|https://cdn.jsdelivr.net/npm/bootstrap@[^/]*/dist/js/bootstrap.min.js|{{ asset('\''assets/bootstrap/bootstrap.bundle.min.js'\'') }}|g' "$file"
        CHANGED=1
    fi

    # jQuery
    if grep -q "code.jquery.com/jquery" "$file" || grep -q "cdn.jsdelivr.net/npm/jquery" "$file"; then
        sed -i 's|https://code.jquery.com/jquery-[0-9.]*.min.js|{{ asset('\''assets/jquery/jquery-3.7.0.min.js'\'') }}|g' "$file"
        sed -i 's|https://cdn.jsdelivr.net/npm/jquery@[^/]*/dist/jquery.min.js|{{ asset('\''assets/jquery/jquery-3.7.0.min.js'\'') }}|g' "$file"
        CHANGED=1
    fi

    # DataTables CSS
    if grep -q "cdn.datatables.net.*\.css" "$file"; then
        sed -i 's|https://cdn.datatables.net/[0-9.]*/css/dataTables.bootstrap5.min.css|{{ asset('\''assets/datatables/dataTables.bootstrap5.min.css'\'') }}|g' "$file"
        sed -i 's|https://cdn.datatables.net/[0-9.]*/css/jquery.dataTables.min.css|{{ asset('\''assets/datatables/dataTables.bootstrap5.min.css'\'') }}|g' "$file"
        CHANGED=1
    fi

    # DataTables JS
    if grep -q "cdn.datatables.net.*\.js" "$file"; then
        sed -i 's|https://cdn.datatables.net/[0-9.]*/js/jquery.dataTables.min.js|{{ asset('\''assets/datatables/jquery.dataTables.min.js'\'') }}|g' "$file"
        sed -i 's|https://cdn.datatables.net/[0-9.]*/js/dataTables.bootstrap5.min.js|{{ asset('\''assets/datatables/dataTables.bootstrap5.min.js'\'') }}|g' "$file"
        CHANGED=1
    fi

    # Chart.js
    if grep -q "cdn.jsdelivr.net/npm/chart.js" "$file" || grep -q "cdnjs.cloudflare.com/ajax/libs/Chart.js" "$file"; then
        sed -i 's|https://cdn.jsdelivr.net/npm/chart.js@[^/]*/dist/chart.*.js|{{ asset('\''assets/chartjs/chart.min.js'\'') }}|g' "$file"
        sed -i 's|https://cdnjs.cloudflare.com/ajax/libs/Chart.js/[^/]*/chart.*.js|{{ asset('\''assets/chartjs/chart.min.js'\'') }}|g' "$file"
        CHANGED=1
    fi

    # Font Awesome
    if grep -q "cdnjs.cloudflare.com/ajax/libs/font-awesome" "$file" || grep -q "use.fontawesome.com" "$file"; then
        sed -i 's|https://cdnjs.cloudflare.com/ajax/libs/font-awesome/[^/]*/css/all.min.css|{{ asset('\''assets/fontawesome/all.min.css'\'') }}|g' "$file"
        sed -i 's|https://use.fontawesome.com/releases/v[^/]*/css/all.css|{{ asset('\''assets/fontawesome/all.min.css'\'') }}|g' "$file"
        CHANGED=1
    fi

    # SweetAlert2
    if grep -q "cdn.jsdelivr.net/npm/sweetalert2" "$file"; then
        sed -i 's|https://cdn.jsdelivr.net/npm/sweetalert2@[^/]*/dist/sweetalert2.min.css|{{ asset('\''assets/sweetalert2/sweetalert2.min.css'\'') }}|g' "$file"
        sed -i 's|https://cdn.jsdelivr.net/npm/sweetalert2@[^/]*/dist/sweetalert2.min.js|{{ asset('\''assets/sweetalert2/sweetalert2.min.js'\'') }}|g' "$file"
        CHANGED=1
    fi

    if [ $CHANGED -eq 1 ]; then
        echo "  Updated: $file"
        ((UPDATED++))
    fi
done

echo -e "\n${GREEN}✓ Updated $UPDATED files${NC}"

# Show remaining CDN links
echo -e "\n${YELLOW}[3/3] Checking for remaining CDN links...${NC}"
REMAINING=$(grep -r "https://cdn\." resources/views/ --include="*.blade.php" 2>/dev/null | wc -l)
if [ $REMAINING -gt 0 ]; then
    echo -e "${YELLOW}⚠ Found $REMAINING remaining CDN links:${NC}"
    grep -r "https://cdn\." resources/views/ --include="*.blade.php" -n | head -10
    echo ""
    echo "Review these manually if needed."
else
    echo -e "${GREEN}✓ No CDN links found${NC}"
fi

echo -e "\n${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}            Update Complete!                                ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

echo -e "\n${BLUE}Summary:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "Total blade files: $FILE_COUNT"
echo "Files updated: $UPDATED"
echo "Backup location: $BACKUP_DIR"

echo -e "\n${YELLOW}Next Steps:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "1. Clear view cache:"
echo "   docker-compose exec php php artisan view:clear"
echo ""
echo "2. Test application in browser (disable internet to verify)"
echo ""
echo "3. If something breaks, restore from backup:"
echo "   cp -r $BACKUP_DIR/resources/views/* resources/views/"
echo ""
echo "4. Check your custom assets in:"
echo "   - resources/views/layouts/app.blade.php"
echo "   - resources/views/layouts/admin.blade.php"
echo "   - Any custom layout files"
