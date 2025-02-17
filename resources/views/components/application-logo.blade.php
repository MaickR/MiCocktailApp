<svg width="100%" height="auto" viewBox="0 0 500 150" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <mask id="reveal">
            <rect width="500" height="150" fill="black" />
            <rect y="0" width="0" height="150" fill="white">
                <animate attributeName="width" from="0" to="500" dur="3s" fill="freeze" />
            </rect>
        </mask>
    </defs>
    
    <!-- Clickable main text linking to GitHub -->
    <a xlink:href="https://github.com/MaickR" target="_blank" style="text-decoration:none;">
        <text x="50%" y="60" text-anchor="middle" font-family="'Press Start 2P', monospace" font-size="30" fill="black" mask="url(#reveal)">
            &lt;Mike_Dev/&gt;
        </text>
    </a>
    
    <!-- Larger subtext, responsive and animated -->
    <text x="50%" y="120" text-anchor="middle" font-family="'Press Start 2P', monospace" font-size="47" fill="black" opacity="0">
        🍹MI COCKTAIL APP🍸
        <animate attributeName="opacity" from="0" to="1" begin="3s" dur="1s" fill="freeze" />
        <animate attributeName="y" from="130" to="120" begin="3s" dur="1s" fill="freeze" />
    </text>
</svg>
