# Purecolor
🎨 简单轻量的色板网站

# Demo
[tool.solstice23.top/color](https://tool.solstice23.top/color/)

# 部署
1. 导入 `palettes.sql` 文件 
2. 在 `config.php` 中配置数据库参数

## Nginx 伪静态
```
rewrite /p/(.*?)/?$ /index.php?subdir&id=$1;
```