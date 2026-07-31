FROM nginx:alpine

# Copy custom nginx configuration
COPY conf.d/app.conf /etc/nginx/conf.d/default.conf

# Remove default nginx configuration
RUN rm /etc/nginx/conf.d/default.conf

# Install dependencies
RUN apk add --no-cache curl

# Set working directory
WORKDIR /var/www/html

# Expose port
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]
