import os
import re
import glob

views_dir = '/Users/sastrawangsa/terrasys-property-manager/resources/views'

# Subtitles mapped by keywords or exact paths
subtitles = {
    'reports/expiring-certificates.blade.php': 'Monitor certificates that are nearing their expiration dates.',
    'reports/idle-properties.blade.php': 'Track properties that are currently not in active use.',
    'reports/assets-by-region.blade.php': 'Analyze property distribution and valuation by region.',
    'reports/assets-by-land-right.blade.php': 'Analyze property distribution based on land rights type.',
    'map/index.blade.php': 'Visual distribution of your entire property portfolio.',
    'properties/create.blade.php': 'Add a new property to your portfolio.',
    'properties/edit.blade.php': 'Update information and details of the property.',
    'certificates/create.blade.php': 'Add a new legal certificate for a property.',
    'certificates/edit.blade.php': 'Update information for this certificate.',
    'lease-contracts/create.blade.php': 'Create a new lease contract for a property.',
    'lease-contracts/edit.blade.php': 'Modify existing lease contract details.',
    'documents/create.blade.php': 'Upload a new document related to a property.',
    'documents/show.blade.php': 'View detailed information about this document.',
    'additional-certificates/index.blade.php': 'Manage secondary or supplementary property certificates.',
    'additional-certificates/create.blade.php': 'Add a new supplementary certificate.',
    'additional-certificates/edit.blade.php': 'Update supplementary certificate details.',
    'admin/users/form.blade.php': 'Create or update system user details.',
    'admin/roles/edit.blade.php': 'Configure permissions for this specific role.',
    'admin/master-data/index.blade.php': 'Manage core reference data used across the system.',
    'admin/master-data/form.blade.php': 'Create or update master data entries.',
    'admin/audit-logs/index.blade.php': 'Review chronological records of system activities.',
    'admin/system-settings/index.blade.php': 'Configure global system parameters and preferences.',
    'notifications/index.blade.php': 'View your recent system alerts and updates.',
    'properties/show.blade.php': 'Comprehensive view of the property details.',
    'certificates/show.blade.php': 'Detailed information regarding the certificate.',
    'lease-contracts/show.blade.php': 'View complete details of the lease contract.',
}

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    rel_path = os.path.relpath(filepath, views_dir)
    
    # Check if the file has <x-slot name="header">
    if '<x-slot name="header">' not in content:
        return False
        
    # First, let's update existing <p class="text-sm..."> to <p class="hidden lg:block text-sm...">
    # Regex to find existing <p> tags with text-sm
    content = re.sub(
        r'<p class="text-sm text-gray-500 mt-1">',
        r'<p class="hidden lg:block text-sm text-gray-500 mt-1">',
        content
    )
    
    # Now look for simple headers that need the new structure.
    # Typically they look like: <x-slot name="header">\s*<h2 class="text-xl font-semibold text-gray-800">\s*(.*?)\s*</h2>\s*</x-slot>
    # Or with a wrapper: <x-slot name="header">\s*<div class="flex items-center justify-between">\s*<h2 class="text-xl font-semibold text-gray-800">\s*(.*?)\s*</h2>
    
    subtitle = subtitles.get(rel_path, 'Manage your data and configurations.')
    
    # Pattern 1: Just the h2
    pattern1 = re.compile(r'(<x-slot name="header">)\s*<h2 class="text-xl font-semibold text-gray-800">(.*?)</h2>\s*(</x-slot>)', re.IGNORECASE | re.DOTALL)
    
    def repl1(match):
        title = match.group(2).strip()
        # Remove curly braces from title if it's dynamic
        return f'{match.group(1)}\n    <div class="flex items-center justify-between w-full">\n        <div>\n            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{title}</h2>\n            <p class="hidden lg:block text-sm text-gray-500 mt-1">{subtitle}</p>\n        </div>\n    </div>\n{match.group(3)}'

    content = pattern1.sub(repl1, content)
    
    # Pattern 2: wrapped in div flex
    pattern2 = re.compile(r'(<x-slot name="header">)\s*<div class="flex items-center justify-between(?: w-full)?">\s*(<h2 class="text-xl font-semibold text-gray-800">.*?</h2>)(.*?</x-slot>)', re.IGNORECASE | re.DOTALL)
    
    def repl2(match):
        h2_full = match.group(2)
        rest = match.group(3)
        # Extract title text
        title_match = re.search(r'>([^<]+)<', h2_full)
        title = title_match.group(1).strip() if title_match else 'Title'
        return f'{match.group(1)}\n    <div class="flex items-center justify-between w-full">\n        <div>\n            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{title}</h2>\n            <p class="hidden lg:block text-sm text-gray-500 mt-1">{subtitle}</p>\n        </div>{rest}'

    # We only apply pattern2 if it doesn't already have <p class="hidden lg:block
    if '<p class="hidden lg:block text-sm text-gray-500 mt-1">' not in content:
        content = pattern2.sub(repl2, content)

    with open(filepath, 'w') as f:
        f.write(content)
        
    return True

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))

print("Header update complete.")
