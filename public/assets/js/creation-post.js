function dropHandler(ev) {
    console.log("File(s) dropped");
    ev.preventDefault();

    const preview = document.getElementById('preview');
    preview.innerHTML = ''; // Clear previous preview

    const files = ev.dataTransfer.items
        ? [...ev.dataTransfer.items].filter(item => item.kind === "file").map(item => item.getAsFile())
        : [...ev.dataTransfer.files];

    files.forEach(file => {
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "100%";
                img.style.height = "100%";
                img.style.objectFit = "cover";
                img.style.display = "block"; //for no spacing
                preview.appendChild(img);

                //hide text and icon for non-bg img
                document.querySelector('.upload-text').style.display = 'none';
                document.querySelector('.upload-note').style.display = 'none';
                document.querySelector('.upload-icon').style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = "<p>Only image files are supported.</p>";
        }
    });
}

function dragOverHandler(ev) {
    ev.preventDefault();
    console.log("File(s) in drop zone");
}

// Handle manual file selection
function handleFileInput(input) {
    console.log("File added manually");
    const file = input.files[0];
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.style.width = "100%";
            img.style.height = "100%";
            img.style.objectFit = "cover";
            preview.appendChild(img);

            //hide text and icon for non-bg img
            document.querySelector('.upload-text').style.display = 'none';
            document.querySelector('.upload-note').style.display = 'none';
            document.querySelector('.upload-icon').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}