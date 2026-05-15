import re

filepath = '/Users/sastrawangsa/terrasys-property-manager/resources/views/layouts/sidebar.blade.php'

with open(filepath, 'r') as f:
    content = f.read()

# Replace menu items that might have whitespace around them
replacements = [
    (r'>\s*Dashboard\s*<', '>Dasbor<'),
    (r'>\s*Properties\s*<', '>Properti<'),
    (r'>\s*Certificates\s*<', '>Sertifikat<'),
    (r'>\s*Leases\s*<', '>Kontrak Sewa<'),
    (r'>\s*Documents\s*<', '>Dokumen<'),
    (r'>\s*Reports\s*<', '>Laporan<'),
    (r'>\s*Map\s*<', '>Peta<'),
    (r'>\s*Admin Area\s*<', '>Area Admin<'),
]

for pattern, replacement in replacements:
    # Need to retain the leading/trailing spaces for proper formatting? 
    # Actually, the blade file has: </svg>\n   Properties\n</a>
    # A regex substitution is best done carefully:
    content = re.sub(r'(\s+)Dashboard(\s+)', r'\g<1>Dasbor\g<2>', content)
    content = re.sub(r'(\s+)Properties(\s+)', r'\g<1>Properti\g<2>', content)
    content = re.sub(r'(\s+)Certificates(\s+)', r'\g<1>Sertifikat\g<2>', content)
    content = re.sub(r'(\s+)Leases(\s+)', r'\g<1>Kontrak Sewa\g<2>', content)
    content = re.sub(r'(\s+)Documents(\s+)', r'\g<1>Dokumen\g<2>', content)
    content = re.sub(r'(\s+)Reports(\s+)', r'\g<1>Laporan\g<2>', content)
    content = re.sub(r'(\s+)Map(\s+)', r'\g<1>Peta\g<2>', content)
    content = re.sub(r'(\s+)Admin Area(\s+)', r'\g<1>Area Admin\g<2>', content)

with open(filepath, 'w') as f:
    f.write(content)

print("Sidebar translated successfully.")
