<canvas id="canvas"></canvas>
<img id="source" src="{{ $image }}" style="display:none;">

<script>
    const image = document.getElementById('source');
    const canvas = document.getElementById('canvas');
    const boxes = @json($boxes);

    image.onload = () => {
        canvas.width = image.naturalWidth;
        canvas.height = image.naturalHeight;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(image, 0, 0);

        boxes.forEach(box => {
            const centerX = box.reduce((sum, v) => sum + v.x, 0) / box.length;
            const centerY = box.reduce((sum, v) => sum + v.y, 0) / box.length;
            const radius = Math.max(...box.map(v => Math.hypot(centerX - v.x, centerY - v.y))) * 1.1;

            ctx.beginPath();
            ctx.strokeStyle = 'red';
            ctx.lineWidth = 3;
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.stroke();
        });
    };
</script>
